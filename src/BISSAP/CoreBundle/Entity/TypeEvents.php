<?php

namespace BISSAP\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeEvents
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="BISSAP\CoreBundle\Entity\TypeEventsRepository")
 */
class TypeEvents
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
     * @ORM\OneToMany(targetEntity="Events", mappedBy="typeEvents", cascade={"persist", "remove", "merge"})
     */
    // private $events;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

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
     * Set type
     *
     * @param string $type
     *
     * @return TypeEvents
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return TypeEvents
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
         $this->genreEvents = new \Doctrine\Common\Collections\ArrayCollection();
    }


    public function __toString()
    {
        return $this->type;
    }


    /**
     * Add event
     *
     * @param \BISSAP\CoreBundle\Entity\Events $event
     *
     * @return TypeEvents
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
}
