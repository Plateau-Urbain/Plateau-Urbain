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
     * @ORM\OneToMany(targetEntity="SpaceAttribute", mappedBy="space", cascade={"persist", "merge", "remove"} )
     */
    protected $spaceAttributes;

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

    public function __construct()
    {
        $this->spaceAttributes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pics = new \Doctrine\Common\Collections\ArrayCollection();
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
        $this->pics->removeElement($pics);
    }

    /**
     * @return mixed
     */
    public function getSpaceAttributes()
    {
        return $this->spaceAttributes;
    }

    /**
     * @param mixed $spaceAttributes
     */
    public function setSpaceAttributes($spaceAttributes)
    {
        $this->spaceAttributes = $spaceAttributes;

        foreach ($spaceAttributes as  $spaceAttribute) {
            $spaceAttribute->setSpace($this);
        }
    }
    /**
     * Add spaceAttribute.
     *
     * @param \AppBundle\Entity\SpaceAttribute $spaceAttribute
     *
     * @return Space
     */
    public function addSpaceAttribute(\AppBundle\Entity\SpaceAttribute $spaceAttribute)
    {
        $this->spaceAttributes[] = $spaceAttribute;

        if ($spaceAttribute->getSpace() !== $this) {
            $spaceAttribute->setSpace($this);
        }

        return $this;
    }

    /**
     * Remove spaceAttribute.
     *
     * @param \AppBundle\Entity\SpaceAttribute $spaceAttribute
     */
    public function removeSpaceAttribute(\AppBundle\Entity\SpaceAttribute $spaceAttribute)
    {
        $this->spaceAttributes->removeElement($spaceAttribute);
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
}
