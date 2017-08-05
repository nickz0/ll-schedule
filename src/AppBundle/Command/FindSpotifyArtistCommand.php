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

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

        parent::__construct();
    }

    public function configure()
    {
        $this
            ->setName('app:spotify-artist')
            ->setDescription('Search spotify for artists')
            ->addArgument('token', InputArgument::REQUIRED, 'Spotify API-Token');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $acts = $this->em->getRepository(Act::class)->findAll();

        $client = new Client([
            'base_uri' => 'https://api.spotify.com'
        ]);

        foreach($acts as $act) {

            if($act) {

            }
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
                dump($name);
                dump($id);
            }
        }
    }

}