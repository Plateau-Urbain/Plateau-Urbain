<?php
// vim:expandtab:sw=4 softtabstop=4:

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Gedmo\Mapping\Annotation as Gedmo;
use AppBundle\Entity\User;
use AppBundle\Entity\SpaceImage;

/**
 * Space
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SpaceRepository")
 */
class Space
{
    const MAX_PICTURES_UPLOAD = 20;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     * @Assert\NotBlank(groups={"save"})
     * @Assert\Length(max=255)
     */
    private $name;

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
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Assert\NotBlank(groups={"save"})
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="activity_description", type="text", nullable=true)
     * @Assert\NotBlank(groups={"save"})
     */
    private $activityDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="locationDescription", type="text", nullable=true)
     */
    private $locationDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="usageRestriction", type="text", nullable=true)
     */
    private $usageRestriction;

    /**
     * @var string
     *
     * @ORM\Column(name="surface", type="float", nullable=true)
     */
    private $surface;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="zip_code", type="string", length=255, nullable=true)
     * @Assert\NotBlank(groups={"save"})
     * @Assert\Length(max="5", min="5", minMessage="Code postal invalide", maxMessage="Code postal invalide", groups={"draft", "save"})
     * @Assert\Regex(pattern="/[0-9]{2}[0-9]{3}/", message="Code postal invalide", groups={"draft", "save"})
     *
     */
    private $zipCode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     * @Assert\NotBlank(groups={"save"})
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="size", type="string", length=255, nullable=true)
     */
    private $size;

    /**
     * @var string
     *
     * @ORM\Column(name="availability", type="string", length=255, nullable=true)
     * @Assert\NotBlank(groups={"save"})
     */
    private $availability;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="limitAvailability", type="date", nullable=true)
     * @Assert\NotBlank(groups={"save"})
     */
    private $limitAvailability;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="float", nullable=true)
     * @Assert\NotBlank(groups={"save"})
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity="SpaceImage", mappedBy="space", orphanRemoval=true, cascade={"persist", "remove"})
     * @ORM\OrderBy({"position"="ASC"})
     */
    protected $pics;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="spaces")
     * @Assert\NotBlank(groups={"save"})
     */
    protected $owner;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="closed", type="boolean")
     */
    private $closed = false;

    /**
     * @ORM\OneToMany(targetEntity="Parcel", mappedBy="space", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $parcels;

    /**
     * @ORM\OneToMany(targetEntity="SpaceDocument", mappedBy="space", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $documents;

    /**
     * @ORM\OneToMany(targetEntity="SpaceAttribute", mappedBy="space", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $tags;

    /**
     * @ORM\ManyToOne(targetEntity="SpaceType")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $type;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", name="is_submitted")
     */
    private $submitted = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", name="submitted_at", nullable=true)
     */
    private $submittedAt;

    /**
     * @ORM\OneToMany(
     *     targetEntity="Application", mappedBy="space"
     * )
     */
    private $application;

    /**
     * @return ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param SpaceAttribute $tag
     *
     * @return $this
     */
    public function addTag($tag)
    {
        $this->setUpdated(new \DateTime());
        $tag->setSpace($this);
        $this->tags[] = $tag;
    }

    /**
     * @param SpaceAttribute $tag
     */
    public function removeTag($tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Space constructor.
     */
    public function __construct()
    {
        $this->pics = new ArrayCollection();
        $this->requiredDocs = new ArrayCollection();
        $this->parcels = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->documents = new ArrayCollection();
    }
    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Space
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Space
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set activityDescription.
     *
     * @param string $activityDescription
     *
     * @return Space
     */
    public function setActivityDescription($activityDescription)
    {
        $this->activityDescription = $activityDescription;

        return $this;
    }

    /**
     * Get activityDescription.
     *
     * @return string
     */
    public function getActivityDescription()
    {
        return $this->activityDescription;
    }


    /**
     * Set locationDescription.
     *
     * @param string $locationDescription
     *
     * @return Space
     */
    public function setLocationDescription($locationDescription)
    {
        $this->locationDescription = $locationDescription;

        return $this;
    }

    /**
     * Get locationDescription.
     *
     * @return string
     */
    public function getLocationDescription()
    {
        return $this->locationDescription;
    }

    /**
     * Set usageRestriction.
     *
     * @param string $usageRestriction
     *
     * @return Space
     */
    public function setUsageRestriction($usageRestriction)
    {
        $this->usageRestriction = $usageRestriction;

        return $this;
    }

    /**
     * Get usageRestriction.
     *
     * @return string
     */
    public function getUsageRestriction()
    {
        return $this->usageRestriction;
    }

    /**
     * Set surface.
     *
     * @param string $surface
     *
     * @return Space
     */
    public function setSurface($surface)
    {
        $this->surface = $surface;

        return $this;
    }

    /**
     * Get surface.
     *
     * @return string
     */
    public function getSurface()
    {
        return $this->surface;
    }

    /**
     * Set size.
     *
     * @param string $size
     *
     * @return Space
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size.
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set availability.
     *
     * @param string $availability
     *
     * @return Space
     */
    public function setAvailability($availability)
    {
        $this->availability = $availability;

        return $this;
    }

    /**
     * Get availability.
     *
     * @return string
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * Set limitAvailability.
     *
     * @param \DateTime $limitAvailability
     *
     * @return Space
     */
    public function setLimitAvailability($limitAvailability)
    {
        $this->limitAvailability = $limitAvailability;

        return $this;
    }

    /**
     * Get limitAvailability.
     *
     * @return \DateTime
     */
    public function getLimitAvailability()
    {
        return $this->limitAvailability;
    }

    /**
     * Set price.
     *
     * @param float $price
     *
     * @return Space
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return ArrayCollection|SpaceImage[]
     */
    public function getPics()
    {
        $pics = [];

        foreach ($this->pics as $p) {
            if ($p->getFileType() === SpaceImage::FILETYPE_IMAGE || $p->getFileType() === null) {
                $pics[] = $p;
            }
        }

        return $pics;
    }

    /**
     * @return ArrayCollection|SpaceImage[]
     */
    public function getDocs($type = null)
    {
        $docs = [];

        foreach ($this->pics as $p) {
            if ($p->getFileType() !== SpaceImage::FILETYPE_IMAGE) {
                $docs[] = $p;
            }
        }

        if ($type) {
            $docs = array_values(array_filter($docs, function ($doc) use ($type) {
                return $doc->getFileType() === $type;
            }));
        }

        return $docs;
    }

    /**
     * Add pics.
     *
     * @param SpaceImage $pic
     *
     * @return Space
     */
    public function addPic(SpaceImage $pic)
    {
        $pic->setSpace($this);
        $pic->setFileType(SpaceImage::FILETYPE_IMAGE);
        $this->pics->add($pic);

        $this->setUpdated(new \DateTime());

        return $this;
    }

    /**
     * Add doc.
     *
     * @param SpaceImage $doc
     *
     * @return Space
     */
    public function addDoc(SpaceImage $doc, $type)
    {
        $doc->setSpace($this);
        $doc->setFileType($type);
        $this->pics->add($doc);

        $this->setUpdated(new \DateTime());

        return $this;
    }

    /**
     * Remove pics.
     *
     * @param \AppBundle\Entity\SpaceImage $pics
     */
    public function removePic(SpaceImage $pics)
    {
        $this->pics->removeElement($pics);
        $this->setUpdated(new \DateTime());
    }

    /**
     * Remove docs.
     *
     * @param \AppBundle\Entity\SpaceImage $docs
     */
    public function removeDoc(SpaceImage $docs)
    {
        $this->pics->removeElement($docs);
        $this->setUpdated(new \DateTime());
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return bool
     */
    public function isClosed()
    {
        if ($this->closed || $this->getLimitAvailability() < new \DateTime('today')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function getClosed()
    {
        return $this->closed;
    }

    /**
     * @param bool $closed
     */
    public function setClosed($closed)
    {
        $this->closed = $closed;
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param User $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return \Datetime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return \Datetime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param \Datetime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @param \Datetime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * @return mixed
     */
    public function getParcels()
    {
        return $this->parcels;
    }

    /**
     * @param mixed $parcels
     */
    public function setParcels($parcels)
    {
        $this->parcels = $parcels;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $parcels
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param mixed $zipCode
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
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
    public function addParcel(Parcel $parcel)
    {
        $this->setUpdated(new \DateTime());
        $this->parcels->add($parcel);

        $parcel->setSpace($this);

        return $this;
    }

    /**
     * @param mixed $parcels
     */
    public function removeParcel($parcel)
    {
        $this->parcels->removeElement($parcel);
    }

    /**
     * @param SpaceType
     *
     * @return Parcel
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return SpaceType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public  function __toString()
    {
        return $this->getName().' - '.($this->getOwner() != null ? $this->getOwner()->getCompany() : '');
    }

    /**
     * @return int
     */
    public function getMinSize() {
        $min = -1;
        foreach ($this->getParcels() as $parcel) {
            if ($min == -1 || $min > $parcel->getSurface()) {
                $min = $parcel->getSurface();
            }
        }
        return $min;
    }

    /**
     * @return int
     */
    public function getMaxSize() {
        $max = 0;
        foreach ($this->getParcels() as $parcel) {
            if ($max < $parcel->getSurface()) {
                $max = $parcel->getSurface();
            }
        }
        return $max;
    }

    /**
     * @return boolean
     */
    public function isSubmitted()
    {
        return $this->submitted;
    }

    /**
     * @param boolean $submitted
     */
    public function setSubmitted($submitted)
    {
        $this->submittedAt = new \DateTime();
        $this->submitted = $submitted;
    }

    /**
     * @return \DateTime
     */
    public function getSubmittedAt()
    {
        return $this->submittedAt;
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function isOwner(User $user)
    {
        if ($this->owner) {
            return $this->owner->getId() === $user->getId();
        } else {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function isPublished()
    {
        return $this->enabled && $this->submitted;
    }

    /**
     * @return string
     */
    public function getDepCode() {
        return substr($this->zipCode, 0, 2);
    }

    /**
     * @return mixed
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @param mixed $application
     */
    public function setApplication($application)
    {
        $this->application = $application;
    }

    /**
     * @param $type
     * @return bool
     */
    public function hasTagType($type) {
        foreach ($this->tags as $tag) {
            if ($tag->getAvailability() == $type) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $type
     * @return int
     */
    public function nbApplication($type) {
        $ret = 0;

        $criteria = Criteria::create()->where(Criteria::expr()->neq("status", Application::DRAFT_STATUS));

        if($type == null){
          return count($this->getApplication()->matching($criteria));
        }

        foreach ($this->getApplication()->matching($criteria) as $app) {
            if ($app->getStatus() == $type) {
                $ret++;
            }
        }

        return $ret;
    }

    /**
     * @param $type
     * @return int
     */
    public function nbValidApplication() {
        $criteria = Criteria::create()->where(Criteria::expr()->neq("status", Application::DRAFT_STATUS));

        $ret = $this->getApplication()->matching($criteria)->count();

        return $ret;
    }

    /**
     * @param $useType
     * @return int
     */
    public function nbApplicationUseType($useType) {
        $ret = 0;

        $criteria = Criteria::create()->where(Criteria::expr()->neq("status", Application::DRAFT_STATUS));

        foreach ($this->getApplication()->matching($criteria) as $app) {
          if ($app->getProjectHolder()->getUseType()) {
            if ($app->getProjectHolder()->getUseType()->getId() == $useType->getId()) {
              $ret++;
            }
          }
        }

        return $ret;
    }

    /**
     * @param $category
     * @return int
     */
    public function nbApplicationCategory($category) {
        $ret = 0;

        $criteria = Criteria::create()->where(Criteria::expr()->neq("status", Application::DRAFT_STATUS));

        foreach ($this->getApplication()->matching($criteria) as $app) {
            if ($app->getCategory()->getId() == $category->getId()) {
                $ret++;
            }
        }

        return $ret;
    }

    /**
     * @return int
     */
    public function getTotalWishedSize() {
        $ret = 0;

        $criteria = Criteria::create()->where(Criteria::expr()->neq("status", Application::DRAFT_STATUS));

        foreach ($this->getApplication()->matching($criteria) as $app) {
            $ret += $app->getWishedSize();
        }

        return $ret;
    }

    /**
     * @Assert\Callback(groups="save")
     * @param ExecutionContextInterface $context
     */
    public function validateNbParcels(ExecutionContextInterface $context)
    {
        if ($this->parcels->count() < 0) {
            $context->buildViolation('Vous devez créer au moins un lot pour votre espace.')
                    ->atPath('newParcel')
                    ->addViolation();
        }
    }

    /**
     * @Assert\Callback(groups="save")
     * @param ExecutionContextInterface $context
     */
    public function validatePicturesCount(ExecutionContextInterface $context)
    {
        if ($this->pics->count() > self::MAX_PICTURES_UPLOAD) {
            $context ->buildViolation('Vous ne pouvez ajouter que {{ nb }} photos maximum')
                     ->atPath('pics')
                     ->setParameter('{{ nb }}', self::MAX_PICTURES_UPLOAD)
                     ->addViolation();
        }
    }

    /**
     * @Assert\Callback(groups="save")
     * @param ExecutionContextInterface $context
     */
    public function validateDocs(ExecutionContextInterface $context)
    {
        if (count($this->getDocs(SpaceImage::FILETYPE_DOCUMENT_AAC)) < 1) {
            $context->buildViolation('Il manque le document de l\'appel à candidature')
                    ->atPath('doc_aac')
                    //->setParameter('{{ value }}', $invalidValue)
                    ->addViolation();
        }

        if (count($this->getDocs(SpaceImage::FILETYPE_DOCUMENT_PLAN)) < 1) {
            $context->buildViolation('Il manque le document de plan')
                    ->atPath('doc_plan')
                    //->setParameter('{{ value }}', $invalidValue)
                    ->addViolation();
        }
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Get submitted
     *
     * @return boolean
     */
    public function getSubmitted()
    {
        return $this->submitted;
    }

    /**
     * Set submittedAt
     *
     * @param \DateTime $submittedAt
     * @return Space
     */
    public function setSubmittedAt($submittedAt)
    {
        $this->submittedAt = $submittedAt;

        return $this;
    }

    /**
     * Add documents
     *
     * @param \AppBundle\Entity\SpaceDocument $documents
     * @return Space
     */
    public function addDocument(\AppBundle\Entity\SpaceDocument $documents)
    {
        $this->documents[] = $documents;

        return $this;
    }

    /**
     * Remove documents
     *
     * @param \AppBundle\Entity\SpaceDocument $documents
     */
    public function removeDocument(\AppBundle\Entity\SpaceDocument $documents)
    {
        $this->documents->removeElement($documents);
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
     * Add application
     *
     * @param \AppBundle\Entity\Application $application
     * @return Space
     */
    public function addApplication(\AppBundle\Entity\Application $application)
    {
        $this->application[] = $application;

        return $this;
    }

    /**
     * Remove application
     *
     * @param \AppBundle\Entity\Application $application
     */
    public function removeApplication(\AppBundle\Entity\Application $application)
    {
        $this->application->removeElement($application);
    }
}
