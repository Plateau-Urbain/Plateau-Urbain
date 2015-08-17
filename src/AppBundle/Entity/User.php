<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User.
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    const PORTEUR = 0;
    const PROPRIO = 1;
    const ADMIN = 2;

    const MISTER = 'M';
    const MISS = 'Mme';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @var string
     * 
     * @ORM\Column(name="civility", length=3, type="string", nullable=true)
     */
    protected $civility;

    /**
     * @var string
     * @Assert\NotBlank(groups={"projectHolder"})
     *
     */
    protected $firstname;

    /**
     * @var string
     * @Assert\NotBlank(groups={"projectHolder"})
     */
    protected $lastname;

    /**
     * @var string
     * 
     * @ORM\Column(name="newsletter", type="boolean", nullable=true)
     */
    protected $newsletter;

    /**
     * @var
     *
     * @ORM\ManyToMany(targetEntity="Group", inversedBy="users")
     * @ORM\JoinTable(name="users_groups")
     */
    protected $groups;

    /**
     * @ORM\Column(length=255, type="string", nullable=true)
     * @Assert\NotBlank(groups={"projectHolder"})
     */
    protected $company;

    /**
     * @ORM\Column(name="company_status", length=255, type="string", nullable=true)
     * @Assert\NotBlank(groups={"projectHolder"})
     */
    protected $companyStatus;

    /**
     * @ORM\Column(name="company_creation_date", type="date", nullable=true)
     * @Assert\NotBlank(groups={"projectHolder"})
     */
    protected $companyCreationDate;

    /**
     * @ORM\Column(length=255, type="string", nullable=true)
     *
     * @Assert\NotBlank(groups={"projectHolder"})
     */
    protected $address;

    /**
     * @ORM\Column(name="address_suite", length=255, type="string", nullable=true)
     *
     * @Assert\NotBlank(groups={"projectHolder"})
     */
    protected $addressSuite;

    /**
     * @ORM\Column(name="company_phone", length=255, type="string", nullable=true)
     *
     * @Assert\NotBlank(groups={"projectHolder"})
     */
    protected $company_phone;

    /**
     * @ORM\Column(name="company_mobile", length=255, type="string", nullable=true)
     *
     * @Assert\NotBlank(groups={"projectHolder"})
     */
    protected $company_mobile;

    /**
     * @ORM\Column(name="company_site", length=255, type="string", nullable=true)
     *
     * @Assert\NotBlank(groups={"projectHolder"})
     */
    protected $company_site;

    /**
     * @ORM\Column(name="company_blog", length=255, type="string", nullable=true)
     *
     * @Assert\NotBlank(groups={"projectHolder"})
     */
    protected $company_blog;

    /**
     * @ORM\Column(length=10, type="string", nullable=true)
     * @Assert\NotBlank(groups={"projectHolder"})
     */
    protected $zipcode;

    /**
     * @ORM\Column(length=255, type="string", nullable=true)
     * @Assert\NotBlank(groups={"projectHolder"})
     */
    protected $city;

    /**
     * @ORM\Column(name="company_description", type="text", nullable=true)
     *
     * @Assert\NotBlank(groups={"projectHolder"})
     */
    protected $companyDescription;

    /**
     * @ORM\Column(name="company_effective", type="integer", nullable=true)
     *
     * @Assert\NotBlank(groups={"projectHolder"})
     */
    protected $companyEffective;

    /**
     * @ORM\Column(name="company_structures", length=255, type="string", nullable=true)
     *
     * @Assert\NotBlank(groups={"projectHolder"})
     */
    protected $companyStructures;

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

    /**PROJECT HOLDER FIELD  **/

    /**
     * @var \Date
     *
     * @ORM\Column(name="birthday", type="date", nullable=true)
     * @Assert\NotBlank(groups={"projectHolder"})
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
     * @ORM\Column(name="google_url", length=255, type="string", nullable=true)
     */
    protected $googleUrl;

    /**
     * @ORM\Column(name="linkedin_url", length=255, type="string", nullable=true)
     */
    protected $linkedinUrl;

    /**
     * @ORM\Column(name="other_url", length=255, type="string", nullable=true)
     */
    protected $otherUrl;

    /**
     * @ORM\Column( type="text", nullable=true)
     * @Assert\NotBlank(groups={"projectHolder"})
     */
    protected $description;


    /**
     * @ORM\Column(length=255, type="string", nullable=true)
     * @Assert\NotBlank(groups={"projectHolder"})
     */
    protected $siret;


    /**
     * @ORM\Column(length=255, type="string", nullable=true)
     * @Assert\NotBlank(groups={"projectHolder"})
     */
    protected $wishedSize;

    /**
     * @ORM\Column(name="usage_date", type="date", nullable=true)
     * @Assert\NotBlank(groups={"projectHolder"})
     */
    protected $usageDate;

    /**
     * @var string
     *
     * @ORM\Column(name="length_type_occupation", type="string", length=5, nullable=true)
     */
    private $lengthTypeOccupation;

    /**
     * @ORM\Column(length=255, type="string", nullable=true)
     * @Assert\NotBlank(groups={"projectHolder"})
     */
    protected $usageDuration;

    /**
     * @ORM\Column(name="usage_description", type="text", nullable=true)
     * @Assert\NotBlank(groups={"projectHolder"})
     */
    protected $usageDescription;

    /**
     * @ORM\ManyToOne(targetEntity="Category" )
     */
    protected $category;

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

    /**
     * @return mixed
     */
    public function getCivility()
    {
        return $this->civility;
    }

    /**
     * @param mixed $civility
     */
    public function setCivility($civility)
    {
        $this->civility = $civility;
    }

    /**
     * @return mixed
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }

    /**
     * @param mixed $newsletter
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;
    }
    
    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }
    
    public static function getAllCivilities() {
        return array(
            self::MISTER => self::MISTER,
            self::MISS => self::MISS
        );
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set companyStatus
     *
     * @param string $companyStatus
     * @return User
     */
    public function setCompanyStatus($companyStatus)
    {
        $this->companyStatus = $companyStatus;

        return $this;
    }

    /**
     * Get companyStatus
     *
     * @return string 
     */
    public function getCompanyStatus()
    {
        return $this->companyStatus;
    }

    /**
     * Set companyCreationDate
     *
     * @param \DateTime $companyCreationDate
     * @return User
     */
    public function setCompanyCreationDate($companyCreationDate)
    {
        $this->companyCreationDate = $companyCreationDate;

        return $this;
    }

    /**
     * Get companyCreationDate
     *
     * @return \DateTime 
     */
    public function getCompanyCreationDate()
    {
        return $this->companyCreationDate;
    }

    /**
     * Set addressSuite
     *
     * @param string $addressSuite
     * @return User
     */
    public function setAddressSuite($addressSuite)
    {
        $this->addressSuite = $addressSuite;

        return $this;
    }

    /**
     * Get addressSuite
     *
     * @return string 
     */
    public function getAddressSuite()
    {
        return $this->addressSuite;
    }

    /**
     * Set company_phone
     *
     * @param string $companyPhone
     * @return User
     */
    public function setCompanyPhone($companyPhone)
    {
        $this->company_phone = $companyPhone;

        return $this;
    }

    /**
     * Get company_phone
     *
     * @return string 
     */
    public function getCompanyPhone()
    {
        return $this->company_phone;
    }

    /**
     * Set company_mobile
     *
     * @param string $companyMobile
     * @return User
     */
    public function setCompanyMobile($companyMobile)
    {
        $this->company_mobile = $companyMobile;

        return $this;
    }

    /**
     * Get company_mobile
     *
     * @return string 
     */
    public function getCompanyMobile()
    {
        return $this->company_mobile;
    }

    /**
     * Set company_site
     *
     * @param string $companySite
     * @return User
     */
    public function setCompanySite($companySite)
    {
        $this->company_site = $companySite;

        return $this;
    }

    /**
     * Get company_site
     *
     * @return string 
     */
    public function getCompanySite()
    {
        return $this->company_site;
    }

    /**
     * Set company_blog
     *
     * @param string $companyBlog
     * @return User
     */
    public function setCompanyBlog($companyBlog)
    {
        $this->company_blog = $companyBlog;

        return $this;
    }

    /**
     * Get company_blog
     *
     * @return string 
     */
    public function getCompanyBlog()
    {
        return $this->company_blog;
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Set googleUrl
     *
     * @param string $googleUrl
     * @return User
     */
    public function setGoogleUrl($googleUrl)
    {
        $this->googleUrl = $googleUrl;

        return $this;
    }

    /**
     * Get googleUrl
     *
     * @return string 
     */
    public function getGoogleUrl()
    {
        return $this->googleUrl;
    }

    /**
     * Set linkedinUrl
     *
     * @param string $linkedinUrl
     * @return User
     */
    public function setLinkedinUrl($linkedinUrl)
    {
        $this->linkedinUrl = $linkedinUrl;

        return $this;
    }

    /**
     * Get linkedinUrl
     *
     * @return string 
     */
    public function getLinkedinUrl()
    {
        return $this->linkedinUrl;
    }

    /**
     * Set otherUrl
     *
     * @param string $otherUrl
     * @return User
     */
    public function setOtherUrl($otherUrl)
    {
        $this->otherUrl = $otherUrl;

        return $this;
    }

    /**
     * Get otherUrl
     *
     * @return string 
     */
    public function getOtherUrl()
    {
        return $this->otherUrl;
    }

    /**
     * Set lengthTypeOccupation
     *
     * @param string $lengthTypeOccupation
     * @return User
     */
    public function setLengthTypeOccupation($lengthTypeOccupation)
    {
        $this->lengthTypeOccupation = $lengthTypeOccupation;

        return $this;
    }

    /**
     * Get lengthTypeOccupation
     *
     * @return string 
     */
    public function getLengthTypeOccupation()
    {
        return $this->lengthTypeOccupation;
    }

    /**
     * Add groups
     *
     * @param \AppBundle\Entity\Group $groups
     * @return User
     */
    public function addGroup(\FOS\UserBundle\Model\GroupInterface $groups)
    {
        $this->groups[] = $groups;

        return $this;
    }

    /**
     * Remove groups
     *
     * @param \AppBundle\Entity\Group $groups
     */
    public function removeGroup(\FOS\UserBundle\Model\GroupInterface $groups)
    {
        $this->groups->removeElement($groups);
    }

    /**
     * Set usageDescription
     *
     * @param string $usageDescription
     * @return User
     */
    public function setUsageDescription($usageDescription)
    {
        $this->usageDescription = $usageDescription;

        return $this;
    }

    /**
     * Get usageDescription
     *
     * @return string 
     */
    public function getUsageDescription()
    {
        return $this->usageDescription;
    }

    /**
     * Set companyDescription
     *
     * @param string $companyDescription
     * @return User
     */
    public function setCompanyDescription($companyDescription)
    {
        $this->companyDescription = $companyDescription;

        return $this;
    }

    /**
     * Get companyDescription
     *
     * @return string 
     */
    public function getCompanyDescription()
    {
        return $this->companyDescription;
    }

    /**
     * Set companyEffective
     *
     * @param integer $companyEffective
     * @return User
     */
    public function setCompanyEffective($companyEffective)
    {
        $this->companyEffective = $companyEffective;

        return $this;
    }

    /**
     * Get companyEffective
     *
     * @return integer 
     */
    public function getCompanyEffective()
    {
        return $this->companyEffective;
    }

    /**
     * Set companyStructures
     *
     * @param string $companyStructures
     * @return User
     */
    public function setCompanyStructures($companyStructures)
    {
        $this->companyStructures = $companyStructures;

        return $this;
    }

    /**
     * Get companyStructures
     *
     * @return string 
     */
    public function getCompanyStructures()
    {
        return $this->companyStructures;
    }
    
    /**
     * Get all company statut
     *
     * @return array
     */
    public static function getAllCompanyStatut() {
        return array(
            'EARL'   =>  'EARL',
            'EI'     => 'EI',
            'EIRL'   => 'EIRL',
            'EURL'   => 'EURL',
            'GAEC'   => 'GAEC',
            'GEIE'   => 'GEIE',
            'GIE'    => 'GIE',
            'SARL'   => 'SARL',
            'SA'     => 'SA',
            'SAS'    => 'SAS',
            'SASU'   => 'SASU',
            'SC'     => 'SC',
            'SCA'    => 'SCA',
            'SCI'    => 'SCI',
            'SCIC'   => 'SCIC',
            'SCM'    => 'SCM',
            'SCOP'   => 'SCOP',
            'SCP'    => 'SCP',
            'SCS'    => 'SCS',
            'SEL'    => 'SEL',
            'SELAFA' => 'SELAFA',
            'SELARL' => 'SELARL',
            'SELAS'  => 'SELAS',
            'SELCA'  => 'SELCA',
            'SEM'    => 'SEM',
            'SEML'   => 'SEML',
            'SEP'    => 'SEP',
            'SICA'   => 'SICA',
            'SNC'    => 'SNC'
            );
    }
}
