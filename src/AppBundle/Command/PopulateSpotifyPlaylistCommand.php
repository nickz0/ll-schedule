<?php

namespace AppBundle\Command;

use AppBundle\Entity\Act;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PopulateSpotifyPlaylistCommand extends Command
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * PopulateSpotifyPlaylistCommand constructor.
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
            ->setName('app:spotify-playlist')
            ->setDescription('Populates the spotify playlist')
            ->addArgument('token', InputArgument::REQUIRED, 'Spotify API-Token');
    }

    /**
     * Post tracks to spotify list.
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
            if(!is_array($act->getSpotifyTopTracks() ) || in_array($act->getStage(), ['echo', 'helga\'s', 'juliet'])) {
                continue;
            }
            sleep(5);

            $path = sprintf('/v1/users/%s/playlists/%s/tracks', 'nickz0', '4xa1SbbgszYsJYhxkigmzo');

            $uris = [];
            foreach($act->getSpotifyTopTracks() as $topTrack) {
                $uris[] =  'spotify:track:' . $topTrack;
            }

            $res = $client->request('POST', $path, [
                'query' => [
                    'uris' => implode(',', $uris)
                ],
                'headers' => [
                    'Authorization' => 'Bearer '.$input->getArgument('token')
                ]
            ]);

            $output->writeln('Populating tracklist with tracks from artist ' . $act->getName() );
            $content = $res->getBody()->getContents();
            $obj = json_decode($content);

            $output->writeln('Added with snapshot ' . $obj->snapshot_id);
        }
    }

}