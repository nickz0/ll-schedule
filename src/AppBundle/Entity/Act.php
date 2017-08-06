<?php

namespace AppBundle\Entity;

/**
 * Act
 */
class Act
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $stage;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTime
     */
    private $starttime;

    /**
     * @var \DateTime
     */
    private $endtime;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $spotifyArtistId;

    /**
     * @var array
     */
    private $spotifyTopTracks;

    public function __construct()
    {
        $this->spotifyTopTracks = [];
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set stage
     *
     * @param string $stage
     *
     * @return Act
     */
    public function setStage($stage)
    {
        $this->stage = $stage;

        return $this;
    }

    /**
     * Get stage
     *
     * @return string
     */
    public function getStage()
    {
        return $this->stage;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Act
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set starttime
     *
     * @param \DateTime $starttime
     *
     * @return Act
     */
    public function setStarttime($starttime)
    {
        $this->starttime = $starttime;

        return $this;
    }

    /**
     * Get starttime
     *
     * @return \DateTime
     */
    public function getStarttime()
    {
        return $this->starttime;
    }

    /**
     * Set endtime
     *
     * @param \DateTime $endtime
     *
     * @return Act
     */
    public function setEndtime($endtime)
    {
        $this->endtime = $endtime;

        return $this;
    }

    /**
     * Get endtime
     *
     * @return \DateTime
     */
    public function getEndtime()
    {
        return $this->endtime;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Act
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getSpotifyArtistId()
    {
        return $this->spotifyArtistId;
    }

    /**
     * @param string $spotifyArtistId
     */
    public function setSpotifyArtistId($spotifyArtistId): Act
    {
        $this->spotifyArtistId = $spotifyArtistId;

        return $this;
    }

    /**
     * @return array
     */
    public function getSpotifyTopTracks()
    {
        return $this->spotifyTopTracks;
    }

    /**
     * @param string $spotifyLastAlbumId
     */
    public function setSpotifyTopTracks($spotifyTopTracks): Act
    {
        $this->spotifyTopTracks = $spotifyTopTracks;

        return $this;
    }

    /**
     * @param $spotifyTopTracksId
     * @return $this
     */
    public function addSpotifyTopTracks($spotifyTopTracksId)
    {
        $this->spotifyTopTracks[] = $spotifyTopTracksId;

        return $this;
    }

}
