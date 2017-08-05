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
     * @var string
     */
    private $spotifyLastAlbumId;

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
    public function getSpotifyArtistId(): string
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
     * @return string
     */
    public function getSpotifyLastAlbumId(): string
    {
        return $this->spotifyLastAlbumId;
    }

    /**
     * @param string $spotifyLastAlbumId
     */
    public function setSpotifyLastAlbumId($spotifyLastAlbumId): Act
    {
        $this->spotifyLastAlbumId = $spotifyLastAlbumId;

        return $this;
    }

}
