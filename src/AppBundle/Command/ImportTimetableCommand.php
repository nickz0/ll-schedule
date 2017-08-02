<?php

namespace AppBundle\Command;

use AppBundle\Entity\Act;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;

class ImportTimetableCommand extends Command
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        parent::__construct();
    }

    public function configure()
    {
       $this
           ->setName('app:import-timetable')
           ->setDescription('Imports online lowlands timetable.');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $data = file_get_contents('http://lowlands.nl/blokkenschema/');
        $crawler = new Crawler($data);
        $events = $crawler->filter('div.timetable-acts a.event__title');

        foreach ($events as $event) {
            $pk = $event->getAttribute('data-pk');
            $day = $this->getDay($crawler, $pk);
            $starttime = $this->getStartTime($crawler, $day, $pk);

            $act = new Act();
            $act->setName(trim($event->textContent));
            $act->setStage($this->getStage($crawler, $pk));
            $act->setStarttime($starttime);
            $act->setEndtime($this->getEndTime($crawler, $starttime, $pk));

            $this->em->persist($act);
        }
        $this->em->flush();
    }

    private function getStage($crawler, $pk): string
    {
        $path = sprintf('//li[ul/li/@data-act-id="%s"]', $pk);
        $location = $crawler->filterXPath($path)->evaluate('substring-after(@class, "location ")');

        return strtolower(reset($location));
    }

    private function getDay($crawler, $pk) {
        $path = sprintf('//ul[li/ul/li/@data-act-id="%s"]', $pk);
        $day = $crawler->filterXPath($path)->evaluate('substring-after(@id, "")');

        return strtolower(reset($day));
    }

    private function getStartTime($crawler, $day, $pk)
    {
        $path = sprintf('//li[@data-act-id="%s"]', $pk);
        $hours = $crawler->filterXPath($path)->evaluate('substring-before(substring-after(@class, "h--"), " m--")');
        $minutes = $crawler->filterXPath($path)->evaluate('substring-before(substring-after(@class, "m--"), " d--")');

        switch ($day) {
            case "friday" :
                $date = "18-08-2017";
                break;
            case "saturday" :
                $date = "19-08-2017";
                break;
            case  "sunday" :
                $date = "20-08-2017";
                break;
        }

        $datetime = new \DateTime($date . $hours[0]. ':'.$minutes[0]);
        if($hours[0] >= 0 && $hours[0] < 8) {
            date_modify($datetime, '+1 day');
        }

        return $datetime;
    }

    private function getEndTime($crawler, $starttime, $pk)
    {
        $path = sprintf('//li[@data-act-id="%s"]', $pk);
        $duration = $crawler->filterXPath($path)->evaluate('substring-after(@class, "d--")');

        $datetime = clone $starttime;

        $modifier = sprintf('+%s minutes', $duration[0]);
        date_modify($datetime, $modifier);

        return $datetime;
    }

}