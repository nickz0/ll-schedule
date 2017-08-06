<?php

namespace AppBundle\Command;


use AppBundle\Entity\Act;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class FindSpotifyTopTracksCommand extends Command
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
            ->setName('app:spotify-top-tracks')
            ->setDescription('Search spotify top tracks for artist')
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
            if($act->getSpotifyArtistId() == '') {
                continue;
            }
            sleep(5);

            $path = sprintf('/v1/artists/%s/top-tracks?country=NL', $act->getSpotifyArtistId());
            $res = $client->request('GET', $path, [
                'headers' => [
                    'Authorization' => 'Bearer '.$input->getArgument('token')
                ]
            ]);

            $output->writeln('Checking top tracks for artist ' . $act->getName() );
            $content = $res->getBody()->getContents();
            $obj = json_decode($content);

            if(count($obj->tracks) > 0) {
                foreach($obj->tracks as $track) {
                    $output->writeln('Found track: '.$track->id);
                    $act->addSpotifyTopTracks($track->id);
                }
                $this->em->persist($act);
                $this->em->flush();
            }
        }
    }

}