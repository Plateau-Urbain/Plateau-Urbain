<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpaceAttribute.
 *
 * @ORM\Table(name="space_attributes")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SpaceAttributeRepository")
 */
class SpaceAttribute
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Space")
     */
    protected $space;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Attribute")
     */
    protected $attribute;

    public function __construct()
    {
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
     * @return SpaceAttribute
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
     * @return mixed
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @param mixed $attribute
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
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
    public function setSpace(\AppBundle\Entity\Space $space)
    {
        $this->space = $space;
    }

    public function __toString()
    {
        return $this->attribute->getName();
    }

//    /**
//     * Add space.
//     *
//     * @param \AppBundle\Entity\Space $pics
//     *
//     * @return Sspace
//     */
//    public function addSpace(\AppBundle\Entity\Space $space)
//    {
//        $this->space[] = $space;
//        if ($space->getSpaceAttributes() !== $this) {
//            $space->setSpaceAttributes($this);
//        }
//
//        return $this;
//    }

//    /**
//     * Remove space.
//     *
//     * @param \AppBundle\Entity\Space $space
//     */
//    public function removeSpace(\AppBundle\Entity\Space $space)
//    {
//        $this->space->removeElement($space);
//    }

//    /**
//     * Add Attributes.
//     *
//     * @param \AppBundle\Entity\Attribute $pics
//     *
//     * @return Sspace
//     */
//    public function addAttribute(\AppBundle\Entity\Attribute $attribute)
//    {
//        $this->attribute[] = $attribute;
//
//        return $this;
//    }
//
//    /**
//     * Remove attribute.
//     *
//     * @param \AppBundle\Entity\Attribute $attribute
//     */
//    public function removeAttribute(\AppBundle\Entity\Attribute $attribute)
//    {
//        $this->attribute->removeElement($attribute);
//    }
}
