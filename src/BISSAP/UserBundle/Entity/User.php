<?php

namespace BISSAP\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="BISSAP\UserBundle\Entity\UserRepository")
 * @UniqueEntity(fields="email", message="Cet Email est deja utilisé.")
 * @UniqueEntity(fields="username", message="Ce nom d'utilisteur est deja utilisé.")
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /** @ORM\Column(name="facebook_id", type="string", length=255, nullable=true) */
    protected $facebook_id;
    /** @ORM\Column(name="facebook_access_token", type="string", length=255, nullable=true) */
    protected $facebook_access_token;
    

    /**
     * @var ArrayCollection $events
     * @ORM\OneToMany(targetEntity="BISSAP\CoreBundle\Entity\Events", mappedBy="user", cascade={"persist" "merge"})
     */
    // private $events;

    /**
     * @ORM\ManyToMany(targetEntity="BISSAP\CoreBundle\Entity\TypeEvents", cascade={"persist", "merge"})
     * @ORM\JoinTable(name="fos_user_typeEvents",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="typeEvents_id", referencedColumnName="id")}
     * )
     */
    protected $typeE;

    /**
     * @ORM\ManyToMany(targetEntity="BISSAP\CoreBundle\Entity\GenreEvents", cascade={"persist", "merge"})
     * @ORM\JoinTable(name="fos_user_genreEvents",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id",onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="genreEvents_id", referencedColumnName="id")}
     * )
     */
    protected $genreE;

    /**
     * @var ArrayCollection $events
     * @ORM\OneToMany(targetEntity="BISSAP\CoreBundle\Entity\Mobility", mappedBy="user", cascade={"persist", "remove", "merge"})
     */
    private $mobilities;


    /**
     * @var string
     *
     * @ORM\Column(name="sex", type="string", length=100)
     */
    private $sex;

    /**
     * @var string
     *
     * @ORM\Column(name="presentation", type="text", nullable=true)
     */
    private $presentation;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=20, nullable=true)
     */
    private $tel;


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
     * Set sex
     *
     * @param string $sex
     * @return User
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex
     *
     * @return string 
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set facebook_id
     *
     * @param string $facebookId
     * @return User
     */
    public function setFacebookId($facebookId)
    {
        $this->facebook_id = $facebookId;

        return $this;
    }

    /**
     * Get facebook_id
     *
     * @return string 
     */
    public function getFacebookId()
    {
        return $this->facebook_id;
    }

    /**
     * Set facebook_access_token
     *
     * @param string $facebookAccessToken
     * @return User
     */
    public function setFacebookAccessToken($facebookAccessToken)
    {
        $this->facebook_access_token = $facebookAccessToken;

        return $this;
    }

    /**
     * Get facebook_access_token
     *
     * @return string 
     */
    public function getFacebookAccessToken()
    {
        return $this->facebook_access_token;
    }

    /**
     * Set presentation
     *
     * @param string $presentation
     * @return User
     */
    public function setPresentation($presentation)
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * Get presentation
     *
     * @return string 
     */
    public function getPresentation()
    {
        return $this->presentation;
    }

    /**
     * Set tel
     *
     * @param string $tel
     * @return User
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string 
     */
    public function getTel()
    {
        return $this->tel;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->mobilities = new ArrayCollection();
        $this->events = new ArrayCollection();
    }

    /**
     * Add mobilities
     *
     * @param \BISSAP\CoreBundle\Entity\Mobility $mobilities
     * @return User
     */
    public function addMobility(\BISSAP\CoreBundle\Entity\Mobility $mobilities)
    {
        $this->mobilities[] = $mobilities;

        return $this;
    }

    /**
     * Remove mobilities
     *
     * @param \BISSAP\CoreBundle\Entity\Mobility $mobilities
     */
    public function removeMobility(\BISSAP\CoreBundle\Entity\Mobility $mobilities)
    {
        $this->mobilities->removeElement($mobilities);
    }

    /**
     * Get mobilities
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMobilities()
    {
        return $this->mobilities;
    }


    /**
     * Add typeE
     *
     * @param \BISSAP\CoreBundle\Entity\TypeEvents $typeE
     * @return User
     */
    public function addTypeE(\BISSAP\CoreBundle\Entity\TypeEvents $typeE)
    {
        $this->typeE[] = $typeE;

        return $this;
    }

    /**
     * Remove typeE
     *
     * @param \BISSAP\CoreBundle\Entity\TypeEvents $typeE
     */
    public function removeTypeE(\BISSAP\CoreBundle\Entity\TypeEvents $typeE)
    {
        $this->typeE->removeElement($typeE);
    }

    /**
     * Get typeE
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTypeE()
    {
        return $this->typeE;
    }

    /**
     * Add genreE
     *
     * @param \BISSAP\CoreBundle\Entity\GenreEvents $genreE
     * @return User
     */
    public function addGenreE(\BISSAP\CoreBundle\Entity\GenreEvents $genreE)
    {
        $this->genreE[] = $genreE;

        return $this;
    }

    /**
     * Remove genreE
     *
     * @param \BISSAP\CoreBundle\Entity\GenreEvents $genreE
     */
    public function removeGenreE(\BISSAP\CoreBundle\Entity\GenreEvents $genreE)
    {
        $this->genreE->removeElement($genreE);
    }

    /**
     * Get genreE
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGenreE()
    {
        return $this->genreE;
    }
}
