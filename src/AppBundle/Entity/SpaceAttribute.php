<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpaceAttribute.
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class SpaceAttribute
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
     * @var bool
     *
     * @ORM\Column(name="availability", type="boolean")
     */
    private $availability;

    /**
     * @ORM\ManyToOne(targetEntity="Space", cascade={"persist"})
     */
    private $space;

    /**
     * @ORM\ManyToOne(targetEntity="Attribute", cascade={"persist"})
     */
    private $attribute;

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
     * Set $space.
     *
     * @param Space $availability
     *
     * @return SpaceAttribute
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
     * Set $space.
     *
     * @param Space $space
     *
     * @return SpaceAttribute
     */
    public function setSpace($space)
    {
        $this->space = $space;

        return $this;
    }

    /**
     * Get space.
     *
     * @return string
     */
    public function getSpace()
    {
        return $this->space;
    }

    /**
     * Get space.
     *
     * @return string
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * Get space.
     *
     * @return string
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
        return $this;
    }
}
