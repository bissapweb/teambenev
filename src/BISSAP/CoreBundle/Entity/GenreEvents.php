<?php

namespace BISSAP\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GenreEvents
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="BISSAP\CoreBundle\Entity\GenreEventsRepository")
 */
class GenreEvents
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var ArrayCollection $events
     * @ORM\OneToMany(targetEntity="Events", mappedBy="genreEvents", cascade={"persist", "remove", "merge"})
     */
    // private $events;

    /**
     * @var string
     *
     * @ORM\Column(name="genre", type="string", length=255)
     */
    private $genre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set genre
     *
     * @param string $genre
     *
     * @return GenreEvents
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return string
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return GenreEvents
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
     * Constructor
     */
    public function __construct()
    {
        $this->events = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add event
     *
     * @param \BISSAP\CoreBundle\Entity\Events $event
     *
     * @return GenreEvents
     */
    public function addEvent(\BISSAP\CoreBundle\Entity\Events $event)
    {
        $this->events[] = $event;

        return $this;
    }

    /**
     * Remove event
     *
     * @param \BISSAP\CoreBundle\Entity\Events $event
     */
    public function removeEvent(\BISSAP\CoreBundle\Entity\Events $event)
    {
        $this->events->removeElement($event);
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvents()
    {
        return $this->events;
    }

    public function __toString()
    {
        return $this->genre;
    }
}
