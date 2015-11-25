<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\ExecutionContextInterface;

/**
 * Application
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ApplicationRepository")
 * @Assert\Callback({"validateContribution"})
 */
class Application
{
    const DAY_TYPE   = "jours";
    const WEEK_TYPE  = "semaines";
    const MONTH_TYPE = "mois";
    const YEAR_TYPE  = "ans";

    const DRAFT_STATUS  = 'draft';
    const WAIT_STATUS   = "awaiting";
    const ACCEPT_STATUS = "accepted";
    const REJECT_STATUS = "rejected";

    /**
     * @return array
     */
    public static function getStatusLabels()
    {
        return array(
            self::DRAFT_STATUS => 'Brouillon',
            self::WAIT_STATUS => 'En attente',
            self::ACCEPT_STATUS => 'Accepté',
            self::REJECT_STATUS => 'Refusé',
        );
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string")
     */
    private $status = self::DRAFT_STATUS;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="contribution", type="text", nullable=true)
     */
    private $contribution;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_occupation", type="date")
     * @Assert\NotBlank()
     */
    private $startOccupation;

    /**
     * @var integer
     *
     * @ORM\Column(name="length_occupation", type="integer")
     * @Assert\NotBlank()
     * @Assert\Type(type="integer", message="La valeur {{ value }} n'est pas un nombre entier valide.")
     */
    private $lengthOccupation;

    /**
     * @var string
     *
     * @ORM\Column(name="length_type_occupation", type="string", length=5)
     * @Assert\NotBlank()
     */
    private $lengthTypeOccupation;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="Space"
     * )
     */
    private $space;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="Category"
     * )
     */
    private $category;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="User"
     * )
     */
    private $projectHolder;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\ApplicationFile",
     *     mappedBy="application",
     *     orphanRemoval=true,
     *     cascade={"persist", "remove"}
     * )
     */
    protected $files;

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="created", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $created;

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    private $updated;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\Type(type="integer", message="La valeur {{ value }} n'est pas un nombre entier valide.")
     */
    protected $wishedSize;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $openToGlobalProject = false;

    /**
     * Application constructor.
     */
    public function __construct()
    {
        $this->files = new ArrayCollection();
    }

    /**
     * @return \Datetime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param \Datetime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
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
     * Set description
     *
     * @param string $description
     * @return Application
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
     * Set description
     *
     * @param string $contribution
     * @return Application
     */
    public function setContribution($contribution)
    {
        $this->contribution = $contribution;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getContribution()
    {
        return $this->contribution;
    }
    /**
     * Set startOccupation
     *
     * @param \DateTime $startOccupation
     * @return Application
     */
    public function setStartOccupation($startOccupation)
    {
        $this->startOccupation = $startOccupation;

        return $this;
    }

    /**
     * Get startOccupation
     *
     * @return \DateTime 
     */
    public function getStartOccupation()
    {
        return $this->startOccupation;
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

    /**
     * @return mixed
     */
    public function getProjectHolder()
    {
        return $this->projectHolder;
    }

    /**
     * @param mixed $projectHolder
     */
    public function setProjectHolder($projectHolder)
    {
        $this->projectHolder = $projectHolder;
    }

    /**
     * @return mixed
     */
    public function getSpace()
    {
        return $this->space;
    }

    /**
     * @param mixed $space
     */
    public function setSpace($space)
    {
        $this->space = $space;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }    
    
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getLengthOccupation()
    {
        return $this->lengthOccupation;
    }

    /**
     * @param string $lengthOccupation
     */
    public function setLengthOccupation($lengthOccupation)
    {
        $this->lengthOccupation = $lengthOccupation;
    }

    /**
     * @return string
     */
    public function getLengthTypeOccupation()
    {
        return $this->lengthTypeOccupation;
    }

    /**
     * @param string $lengthTypeOccupation
     */
    public function setLengthTypeOccupation($lengthTypeOccupation)
    {
        $this->lengthTypeOccupation = $lengthTypeOccupation;
    }

    /**
     * @return ArrayCollection|ApplicationFile[]
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param ApplicationFile $file
     */
    public function addFile(ApplicationFile $file)
    {
        $file->setApplication($this);
        $this->files->add($file);
    }

    /**
     * @param ApplicationFile $file
     */
    public function removeFile(ApplicationFile $file)
    {
        $this->files->removeElement($file);
    }

    /**
     * @return \Datetime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \Datetime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return array
     */
    public static function getAllLengthType() {
        return array(
            self::YEAR_TYPE  => self::YEAR_TYPE,
            self::MONTH_TYPE => self::MONTH_TYPE,
            self::WEEK_TYPE  => self::WEEK_TYPE,
            self::DAY_TYPE   => self::DAY_TYPE
        );
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
    public function getOpenToGlobalProject()
    {
        return $this->openToGlobalProject;
    }

    /**
     * @param mixed $openToGlobalProject
     */
    public function setOpenToGlobalProject($openToGlobalProject)
    {
        $this->openToGlobalProject = $openToGlobalProject;
    }

    /**
     * @return bool
     */
    public function isAwaiting()
    {
        return $this->status === self::WAIT_STATUS;
    }

    /**
     * @return string
     */
    public function isDraft()
    {
        return $this->status === self::DRAFT_STATUS;
    }

    /**
     * @return bool
     */
    public function isAccepted()
    {
        return $this->status === self::ACCEPT_STATUS;
    }

    /**
     * @return bool
     */
    public function isRejected()
    {
        return $this->status === self::REJECT_STATUS;
    }

    /**
     * @return null
     */
    public function getStatusLabel()
    {
        $statusList = self::getStatusLabels();

        if (array_key_exists($this->status, $statusList)) {
            return $statusList[$this->status];
        }

        return null;
    }

    /**
     * @param User $user
     *
     * @return Application
     */
    public static function createFromUser(User $user)
    {
        $application = new Application();

        $application->setDescription($user->getProjectDescription());
        $application->setLengthOccupation($user->getUsageDuration());
        $application->setLengthTypeOccupation($user->getLengthTypeOccupation());
        $application->setWishedSize($user->getWishedSize());
        $application->setProjectHolder($user);
        $application->setCategory($user->getCategory());

        return $application;
    }

    /**
     * @param ExecutionContextInterface $context
     */
    public function validateContribution(ExecutionContextInterface $context)
    {
        $contribution = $this->contribution;
        if ($this->openToGlobalProject && empty($contribution)) {
            $context
                ->addViolationAt('contribution', 'Cette valeur ne doit pas être vide.')
            ;
        }
    }
}
