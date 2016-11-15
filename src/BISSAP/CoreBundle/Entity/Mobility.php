<?php

namespace BISSAP\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mobility
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="BISSAP\CoreBundle\Entity\MobilityRepository")
 */
class Mobility
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
     * @ORM\ManyToOne(targetEntity="BISSAP\UserBundle\Entity\User", inversedBy="mobilities", cascade={"persist"})
     *
     */
    private $user;

    /**
    * @ORM\ManyToOne(targetEntity="Departements")
    */
    protected $departement;

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
     * Set user
     *
     * @param \BISSAP\UserBundle\Entity\User $user
     * @return Mobility
     */
    public function setUser(\BISSAP\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \BISSAP\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set departement
     *
     * @param \BISSAP\CoreBundle\Entity\Departements $departement
     * @return Mobility
     */
    public function setDepartement(\BISSAP\CoreBundle\Entity\Departements $departement = null)
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * Get departement
     *
     * @return \BISSAP\CoreBundle\Entity\Departements 
     */
    public function getDepartement()
    {
        return $this->departement;
    }
}
