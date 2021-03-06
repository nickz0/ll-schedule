<?php

namespace AppBundle\Command;


use AppBundle\Entity\Act;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class FindSpotifyArtistCommand extends Command
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * FindSpotifyArtistCommand constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

        parent::__construct();
    }

    /**
     * Configure the command.
     */
    public function configure()
    {
        $this
            ->setName('app:spotify-artist')
            ->setDescription('Search spotify for artists')
            ->addArgument('token', InputArgument::REQUIRED, 'Spotify API-Token');
    }

    /**
     * Get spotify id and save it.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $acts = $this->em->getRepository(Act::class)->findAll();

        $client = new Client([
            'base_uri' => 'https://api.spotify.com'
        ]);

        foreach($acts as $act) {
            sleep(5);
            $res = $client->request('GET', 'v1/search', [
                'query' => [
                    'q' => $act->getName(),
                    'type' => 'artist'
                ],
                'headers' => [
                    'Authorization' => 'Bearer '.$input->getArgument('token')
                ]
            ]);

            $output->writeln('Checking artist ' . $act->getName() );
            $content = $res->getBody()->getContents();
            $obj = json_decode($content);

            if(count($obj->artists->items) > 0) {
                $id = $obj->artists->items[0]->id;
                $name = $obj->artists->items[0]->name;
                $output->writeln('Found: '.$name . ' with id: '. $id);

                $act->setSpotifyArtistId($id);
                $this->em->persist($act);
                $this->em->flush();
            }

        }
    }

}