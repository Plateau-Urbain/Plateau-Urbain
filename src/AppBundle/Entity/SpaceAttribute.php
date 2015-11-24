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
    const STATUS_NO       = 0; // Non inclus
    const STATUS_INCLUDED = 1; // Inclus
    const STATUS_EXPECTED = 2; // A prévoir

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
     * @ORM\Column(name="availability", type="smallint")
     */
    private $availability = self::STATUS_NO;

    /**
     * @ORM\ManyToOne(targetEntity="Space", inversedBy="tags", cascade={"persist"})
     */
    private $space;

    /**
     * @return Attribute
     *
     * @ORM\ManyToOne(targetEntity="Attribute", inversedBy="tags", cascade={"persist"})
     */
    private $attribute;

    /**
     * @return string
     */
    public function __toString() {
        return (string) $this->attribute->getName();
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
     * Set availability.
     *
     * @param int $availability
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
     * @return int
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
     * @return Space
     */
    public function getSpace()
    {
        return $this->space;
    }

    /**
     * Get space.
     *
     * @return Attribute
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * Get space.
     *
     * @param Attribute $attribute
     *
     * @return $this
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
        return $this;
    }
}
