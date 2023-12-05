<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User.
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @UniqueEntity(
 *      fields={"email"},
 *      message="Vous pouvez réinitialiser votre mot de passe depuis la page connexion."
 * )
 */
class User extends BaseUser
{
    const PORTEUR = 0;
    const PROPRIO = 1;
    const ADMIN = 2;

    const MISTER = 'M';
    const MISS = 'Mme';
    const AUTRE = 'Atr';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
      * @ORM\Column(name="facebook_id", type="string", length=255, nullable=true)
     */
    protected $facebookId;

    /**
      * @ORM\Column(name="google_id", type="string", length=255, nullable=true)
     */
    protected $googleId;

    /**
      * @ORM\Column(name="linkedin_id", type="string", length=255, nullable=true)
     */
    protected $linkedinId;

    /**
     * @var string
     *
     * @ORM\Column(name="civility", length=3, type="string", nullable=true)
     * @Assert\NotBlank(groups={"projectHolder", "owner"})
     */
    protected $civility;

    /**
     * @var string
     * @Assert\NotBlank(groups={"projectHolder", "owner"})
     *
     */
    protected $firstname;

    /**
     * @var string
     * @Assert\NotBlank(groups={"projectHolder", "owner"})
     */
    protected $lastname;

    /**
     * @var string
     * @Assert\Email(groups={"projectHolder", "owner"})
     * @Assert\NotBlank(groups={"projectHolder", "owner"})
     */
    protected $email;

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
     * @Assert\NotBlank(groups={"projectHolder", "owner"})
     */
    protected $company;

    /**
     * @ORM\Column(name="company_status", length=255, type="string", nullable=true)
     * @Assert\NotBlank(groups={"projectHolder", "owner"})
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
     * @Assert\NotBlank(groups={"projectHolder", "owner"})
     */
    protected $address;

    /**
     * @ORM\Column(name="address_suite", length=255, type="string", nullable=true)
     *
     */
    protected $addressSuite;

    /**
     * @ORM\Column(name="company_phone", length=255, type="string", nullable=true)
     *
     */
    protected $companyPhone;

    /**
     * @ORM\Column(name="company_mobile", length=255, type="string", nullable=true)
     *
     */
    protected $companyMobile;

    /**
     * @ORM\Column(name="company_site", length=255, type="string", nullable=true)
     */
    protected $company_site;

    /**
     * @ORM\Column(name="company_blog", length=255, type="string", nullable=true)
     */
    protected $company_blog;

    /**
     * @ORM\Column(length=10, type="string", nullable=true)
     * @Assert\NotBlank(groups={"projectHolder", "owner"})
     * @Assert\Length(max="5", min="5", minMessage="Code postal invalide", maxMessage="Code postal invalide", groups={"projectHolder", "owner"})
     * @Assert\Regex(pattern="/[0-9]{2}[0-9]{3}/", message="Code postal invalide", groups={"projectHolder", "owner"})
     */
    protected $zipcode;

    /**
     * @ORM\Column(length=255, type="string", nullable=true)
     * @Assert\NotBlank(groups={"projectHolder", "owner"})
     */
    protected $city;

    /**
     * @ORM\Column(name="company_function", length=255, type="string", nullable=true)
     *
     */
    protected $companyFunction;

    /**
     * @ORM\Column(name="company_description", type="text", nullable=true)
     *
     */
    protected $companyDescription;

    /**
     * @ORM\Column(name="company_effective", type="integer", nullable=true)
     * @Assert\Range(min = 0, minMessage = "Vous devez obligatoirement renseigner une valeur positive.", groups={"projectHolder"})
     */
    protected $companyEffective;

    /**
     * @ORM\Column(name="company_structures", length=255, type="string", nullable=true)
     *
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
     */
    protected $description;

    /**
     * @ORM\Column(length=255, type="string", nullable=true)
     */
    protected $siret;

    /**
     * @ORM\Column(length=255, type="integer", nullable=true)
     * @Assert\NotBlank(groups={"projectHolder"})
     * @Assert\Type(type="integer", message="La valeur {{ value }} n'est pas un nombre entier valide.", groups={"projectHolder", "register"})
     * @Assert\Range(min = 0, minMessage = "Vous devez obligatoirement renseigner une surface positive.", groups={"projectHolder", "register"})
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
     * @ORM\Column(name="length_type_occupation", type="string", length=15, nullable=true)
     */
    private $lengthTypeOccupation;

    /**
     * @ORM\Column(length=255, type="integer", nullable=true)
     * @Assert\NotBlank(groups={"projectHolder"})
     * @Assert\Type(type="integer", message="La valeur {{ value }} n'est pas un nombre entier valide.", groups={"projectHolder"})
     * @Assert\Range(min = 0, minMessage = "Vous devez obligatoirement renseigner une durée positive.", groups={"projectHolder"})
     */
    protected $usageDuration;

    /**
     * @ORM\Column(name="project_description", type="text", nullable=true)
     */
    protected $projectDescription;

    /**
     * @ORM\ManyToOne(targetEntity="UseType" )
     */
    protected $useType;

    /**
     * @ORM\OneToMany(targetEntity="Application", mappedBy="projectHolder", cascade={"remove"})
     */
    protected $applications;

    /**
     * @ORM\OneToMany(
     *     targetEntity="UserDocument",
     *     mappedBy="projectHolder",
     *     orphanRemoval=true,
     *     cascade={"persist", "remove"}
     * )
     * @Assert\Valid()
     */
    protected $documents;

    /**
     * @ORM\OneToMany(targetEntity="Space", mappedBy="owner", cascade={"remove"})
     */
    protected $spaces;

    public function __toString()
    {
        return $this->getFirstname() . ' ' . $this->getLastname() . ' - ' . $this->getCompany();
    }

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

    public function getEmail()
    {
        return $this->email;
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
     * Is proprio.
     *
     * @return int
     */
    public function isProprio()
    {
        return $this->typeUser == self::PROPRIO;
    }

    /**
     * is porteur.
     *
     * @return int
     */
    public function isPorteur()
    {
        return $this->typeUser == self::PORTEUR;
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
    public function getUseType()
    {
        return $this->useType;
    }

    /**
     * @param mixed $useType
     */
    public function setUseType($useType)
    {
        $this->useType = $useType;
    }

    /**
     * @return array
     */
    public static function getAllCivilities() {
        return array(
            self::MISTER => self::MISTER,
            self::MISS => self::MISS,
            self::AUTRE => 'Autre'
        );
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->groups = new ArrayCollection();
        $this->documents = new ArrayCollection();
        $this->typeUser = self::PORTEUR;
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
     * Set companyPhone
     *
     * @param string $companyPhone
     * @return User
     */
    public function setCompanyPhone($companyPhone)
    {
        $this->companyPhone = $companyPhone;

        return $this;
    }

    /**
     * Get companyPhone
     *
     * @return string
     */
    public function getCompanyPhone()
    {
        return $this->companyPhone;
    }

    /**
     * Set companyMobile
     *
     * @param string $companyMobile
     * @return User
     */
    public function setCompanyMobile($companyMobile)
    {
        $this->companyMobile = $companyMobile;

        return $this;
    }

    /**
     * Get companyMobile
     *
     * @return string
     */
    public function getCompanyMobile()
    {
        return $this->companyMobile;
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
     * Set projectDescription
     *
     * @param string $projectDescription
     * @return User
     */
    public function setProjectDescription($projectDescription)
    {
        $this->projectDescription = $projectDescription;

        return $this;
    }

    /**
     * Get projectDescription
     *
     * @return string
     */
    public function getProjectDescription()
    {
        return $this->projectDescription;
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
     * Set companyDescription
     *
     * @param string $companyFunction
     * @return User
     */
    public function setCompanyFunction($companyFunction)
    {
        $this->companyFunction = $companyFunction;

        return $this;
    }

    /**
     * Get companyDescription
     *
     * @return string
     */
    public function getCompanyFunction()
    {
        return $this->companyFunction;
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
            "Association"                           => "Association",
            "Artiste"                               => "Artiste",
            "ESS"                                   => "ESS",
            "Autoentrepreneur"                      => "Autoentrepreneur",
            "Profession libérale"                   => "Profession libérale",
            "En création"                           => "En création",
            "En phase de lancement de moins 2 ans"  => "En phase de lancement de moins 2 ans"
            );
    }

    /**
     * Get all company statut for pro
     *
     * @return array
     */
    public static function getAllProCompanyStatut() {
        return array(
            'SA' => 'SA',
            'SAS' => 'SAS',
            'SARL' => 'SARL',
            'Auto entrepreneur' => 'Auto entrepreneur',
            'SASU' => 'SASU',
            'EURL' => 'EURL',
            'SCIC' => 'SCIC',
            'SCOP' => 'SCOP',
            'Association loi 1901' => 'Association loi 1901',
            'Association commerciale' => 'Association commerciale',
            'Entreprise individuelle' => 'Entreprise individuelle',
            'Artiste inscrit à la MDA' => 'Artiste inscrit à la MDA',
            'Intermittent' => 'Intermittent',
            'SCI' => 'SCI',
            'SNC' => 'SNC',
            'SELARL' => 'SELARL',
            'SCP' => 'SCP'
        );
    }

    /**
     * @return string
     */
    public function getFullname() {
        return sprintf(
            "%s %s %s",
            $this->getCivility(),
            $this->getFirstname(),
            $this->getLastname()
        );
    }

    /**
     * Set facebookId
     *
     * @param string $facebookId
     * @return User
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;

        return $this;
    }

    /**
     * Get facebookId
     *
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * Add applications
     *
     * @param \AppBundle\Entity\Application $applications
     * @return User
     */
    public function addApplication(\AppBundle\Entity\Application $applications)
    {
        $this->applications[] = $applications;

        return $this;
    }

    /**
     * Remove applications
     *
     * @param \AppBundle\Entity\Application $applications
     */
    public function removeApplication(\AppBundle\Entity\Application $applications)
    {
        $this->applications->removeElement($applications);
    }

    /**
     * Get applications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * Add spaces
     *
     * @param \AppBundle\Entity\Space $spaces
     * @return User
     */
    public function addSpace(\AppBundle\Entity\Space $spaces)
    {
        $this->spaces[] = $spaces;

        return $this;
    }

    /**
     * Add documents
     *
     * @param \AppBundle\Entity\UserDocument $documents
     * @return User
     */
    public function addDocument(\AppBundle\Entity\UserDocument $documents)
    {
        $this->documents[] = $documents;

        return $this;
    }

    /**
     * Remove spaces
     *
     * @param \AppBundle\Entity\Space $spaces
     */
    public function removeSpace(\AppBundle\Entity\Space $spaces)
    {
        $this->spaces->removeElement($spaces);
    }

    /**
     * Get spaces
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSpaces()
    {
        return $this->spaces;
    }

    /**
     * Set googleId
     *
     * @param string $googleId
     * @return User
     */
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;

        return $this;
    }

    /**
     * Get googleId
     *
     * @return string
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }

    /**
     * Set linkedinId
     *
     * @param string $linkedinId
     * @return User
     */
    public function setLinkedinId($linkedinId)
    {
        $this->linkedinId = $linkedinId;

        return $this;
    }

    /**
     * Remove documents
     *
     * @param \AppBundle\Entity\UserDocument $documents
     */
    public function removeDocument(\AppBundle\Entity\UserDocument $documents)
    {
        $this->documents->removeElement($documents);
    }

    /**
     * Has document type
     *
     * @return mixed
     */
    public function hasDocuments($type)
    {
      foreach ($this->documents as $document) {
        if ($document->getType() == $type){
          return true;
        }
      }

      return false;
    }

    /**
     * Has document type
     *
     * @return mixed
     */
    public function getDocumentsType($type)
    {
      $documents = [];

      foreach ($this->documents as $document) {
        if ($document->getType() == $type){
          $documents[] = $document;
        }
      }
      return $documents;
    }

    /**
     * Get documents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * Get linkedinId
     *
     * @return string
     */
    public function getLinkedinId()
    {
        return $this->linkedinId;
    }

}
