<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseUser;

/**
 * User.
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var
     *
     * @ORM\ManyToMany(targetEntity="Group", inversedBy="users")
     * @ORM\JoinTable(name="users_groups")
     */
    protected $groups;

    /**
     * @ORM\Column(length=255, type="string", nullable=true)
     */
    protected $address;

    /**
     * @ORM\Column(length=10, type="string", nullable=true)
     */
    protected $zipcode;

    /**
     * @ORM\Column(length=255, type="string", nullable=true)
     */
    protected $city;

    /**
     * @ORM\Column(length=255, type="string", nullable=true)
     */
    protected $company;

    /**
     * @var int
     *          0 : porteur de projet
     *          1 : proprio
     *          2 : admin
     */

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $typeUser;

    const PORTEUR = 0;
    const PROPRIO = 1;
    const ADMIN = 2;


    /**PROJECT HOLDER FIELD  **/

    /**
     * @var \Date
     *
     * @ORM\Column(name="birthday", type="date")
     */
    private $birthday;



    /**
     * @ORM\Column(length=255, type="string", nullable=true)
     */
    protected $facebookUrl;

    /**
     * @ORM\Column(length=255, type="string", nullable=true)
     */
    protected $instagramUrl;

    /**
     * @ORM\Column(length=255, type="string", nullable=true)
     */
    protected $twitterUrl;

    /**
     * @ORM\Column( type="text", nullable=true)
     */
    protected $description;


    /**
     * @ORM\Column(length=255, type="string", nullable=true)
     */
    protected $siret;


    /**
     * @ORM\Column(length=255, type="string", nullable=true)
     */
    protected $wishedSize;

    /**
     * @ORM\Column(length=255, type="string", nullable=true)
     */
    protected $usageType;


    /**
     * @ORM\Column(length=255, type="string", nullable=true)
     */
    protected $usageDate;

    /**
     * @ORM\Column(length=255, type="string", nullable=true)
     */
    protected $usageDuration;



    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * @return mixed
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * @param mixed $zipcode
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        $this->setUsername($email);
    }

    public function setEmailCanonical($emailCanonical)
    {
        $this->emailCanonical = $emailCanonical;
        $this->setUsernameCanonical($emailCanonical);
    }

    /**
     * Set Type User.
     *
     * @param int $typeUser
     *
     * @return User
     */
    public function setTypeUser($typeUser)
    {
        $this->typeUser = $typeUser;

        return $this;
    }

    /**
     * Get Type User.
     *
     * @return int
     */
    public function getTypeUser()
    {
        return $this->typeUser;
    }


    /**
     * @return mixed
     */
    public function getInstagramUrl()
    {
        return $this->instagramUrl;
    }

    /**
     * @param mixed $instagramUrl
     */
    public function setInstagramUrl($instagramUrl)
    {
        $this->instagramUrl = $instagramUrl;
    }

    /**
     * @return mixed
     */
    public function getSiret()
    {
        return $this->siret;
    }

    /**
     * @param mixed $siret
     */
    public function setSiret($siret)
    {
        $this->siret = $siret;
    }

    /**
     * @return mixed
     */
    public function getUsageDate()
    {
        return $this->usageDate;
    }

    /**
     * @param mixed $usageDate
     */
    public function setUsageDate($usageDate)
    {
        $this->usageDate = $usageDate;
    }

    /**
     * @return mixed
     */
    public function getUsageDuration()
    {
        return $this->usageDuration;
    }

    /**
     * @param mixed $usageDuration
     */
    public function setUsageDuration($usageDuration)
    {
        $this->usageDuration = $usageDuration;
    }

    /**
     * @return mixed
     */
    public function getUsageType()
    {
        return $this->usageType;
    }

    /**
     * @param mixed $usageType
     */
    public function setUsageType($usageType)
    {
        $this->usageType = $usageType;
    }

    /**
     * @return mixed
     */
    public function getWishedSize()
    {
        return $this->wishedSize;
    }

    /**
     * @param mixed $wishedSize
     */
    public function setWishedSize($wishedSize)
    {
        $this->wishedSize = $wishedSize;
    }

    /**
     * @return mixed
     */
    public function getFacebookUrl()
    {
        return $this->facebookUrl;
    }

    /**
     * @param mixed $facebookUrl
     */
    public function setFacebookUrl($facebookUrl)
    {
        $this->facebookUrl = $facebookUrl;
    }

    /**
     * @return mixed
     */
    public function getTwitterUrl()
    {
        return $this->twitterUrl;
    }

    /**
     * @param mixed $twitterUrl
     */
    public function setTwitterUrl($twitterUrl)
    {
        $this->twitterUrl = $twitterUrl;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }


    /**
     * @return \Date
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param \Date $birthday
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }


}
