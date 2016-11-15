<?php

namespace BISSAP\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Regions
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="BISSAP\CoreBundle\Entity\RegionsRepository")
 */
class Regions
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
     * @ORM\OneToMany(targetEntity="Departements", mappedBy="regions", cascade={"persist", "remove", "merge"})
     */

    private $dep;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


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
     * Set name
     *
     * @param string $name
     * @return Regions
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
     * Constructor
     */
    public function __construct()
    {
        $this->dep = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add dep
     *
     * @param \BISSAP\CoreBundle\Entity\Departements $dep
     * @return Regions
     */
    public function addDep(\BISSAP\CoreBundle\Entity\Departements $dep)
    {
        $this->dep[] = $dep;

        return $this;
    }

    /**
     * Remove dep
     *
     * @param \BISSAP\CoreBundle\Entity\Departements $dep
     */
    public function removeDep(\BISSAP\CoreBundle\Entity\Departements $dep)
    {
        $this->dep->removeElement($dep);
    }

    /**
     * Get dep
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDep()
    {
        return $this->dep;
    }

    public function __toString() {
    return $this->name;
}
}
