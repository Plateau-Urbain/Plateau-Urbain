<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Space.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SpaceRepository")
 */
class Space
{
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="locationDescription", type="text")
     */
    private $locationDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="usageRestriction", type="text")
     */
    private $usageRestriction;

    /**
     * @var string
     *
     * @ORM\Column(name="surface", type="string", length=255)
     */
    private $surface;

    /**
     * @var string
     *
     * @ORM\Column(name="size", type="string", length=255)
     */
    private $size;

    /**
     * @var string
     *
     * @ORM\Column(name="availability", type="text")
     */
    private $availability;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="limitAvailability", type="date")
     */
    private $limitAvailability;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="string", length=255)
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity="SpaceImage", mappedBy="space", orphanRemoval=true, cascade={"persist", "remove"})
     */
    protected $pics;

    /**
     * @ORM\ManyToOne(targetEntity="User" )
     */
    protected $owner;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @ORM\oneToMany(targetEntity="Parcel", mappedBy="space", cascade={"persist"})
     */
    private $parcels;

    /**
     * @ORM\ManyToMany(targetEntity="Attribute", cascade={"persist"})
     */
    private $tags;

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param mixed $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return mixed
     */
    public function addTag($tag)
    {
        $this->setUpdated(new \DateTime());
        $this->tags[] = $tag;
    }

    /**
     * @param mixed $tags
     */
    public function removeTag($tag)
    {
        $this->tags->removeElement($tag);
    }

    public function __construct()
    {
        $this->pics = new \Doctrine\Common\Collections\ArrayCollection();
        $this->parcels = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setCreated(new \DateTime());
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
     * @param string $price
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
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getPics()
    {
        return $this->pics;
    }

    /**
     * @param mixed $pics
     */
    public function setPics($pics)
    {
        $this->setUpdated(new \DateTime());
        $this->pics = $pics;

        $this->pics->setGalerie($this);
    }

    /**
     * Add pics.
     *
     * @param \AppBundle\Entity\SpaceImage $pics
     *
     * @return Space
     */
    public function addPic(\AppBundle\Entity\SpaceImage $pics)
    {
        $this->setUpdated(new \DateTime());
        $this->pics[] = $pics;

        return $this;
    }

    /**
     * Remove pics.
     *
     * @param \AppBundle\Entity\SpaceImage $pics
     */
    public function removePic(\AppBundle\Entity\SpaceImage $pics)
    {
        $this->setUpdated(new \DateTime());
        $this->pics->removeElement($pics);
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
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $owner
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
    public function addParcel(Parcel $parcel)
    {
        $this->setUpdated(new \DateTime());
        $this->parcels[] = $parcel;

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

        public  function __toString()
        {
            return $this->getName().' - '.$this->getOwner()->getLastName();
        }

}

