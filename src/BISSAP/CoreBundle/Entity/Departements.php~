<?php

namespace BISSAP\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Departements
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="BISSAP\CoreBundle\Entity\DepartementsRepository")
 */
class Departements
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
     * 
     * @ORM\ManyToOne(targetEntity="Regions", inversedBy="dep", cascade={"persist"})
     *
     */
    private $regions;


    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="num", type="string", length=5)
     */
    private $num;



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
     * @return Departements
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
     * Set num
     *
     * @param string $num
     * @return Departements
     */
    public function setNum($num)
    {
        $this->num = $num;

        return $this;
    }

    /**
     * Get num
     *
     * @return string 
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * Set regions
     *
     * @param \BISSAP\CoreBundle\Entity\Regions $regions
     * @return Departements
     */
    public function setRegions(\BISSAP\CoreBundle\Entity\Regions $regions = null)
    {
        $this->regions = $regions;

        return $this;
    }

    /**
     * Get regions
     *
     * @return \BISSAP\CoreBundle\Entity\Regions 
     */
    public function getRegions()
    {
        return $this->regions;
    }
    public function __toString() {
        
        return $this->name;
    }
}
