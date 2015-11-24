<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Parcel.
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Parcel
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
     * @var int
     *
     * @ORM\Column(name="surface", type="integer")
     * @Assert\NotBlank()
     */
    private $surface;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="disponibility", type="date", nullable=true)
     */
    private $disponibility;

    /**
     * @ORM\ManyToOne(targetEntity="LocalType")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="Floor")
     * @ORM\JoinColumn(name="floor_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $floor;

    /**
     * @ORM\ManyToOne(targetEntity="Space", inversedBy="parcels")
     * @ORM\JoinColumn(name="space_id", referencedColumnName="id")
     */
    private $space;

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
     * Set surface.
     *
     * @param int $surface
     *
     * @return Parcel
     */
    public function setSurface($surface)
    {
        $this->surface = $surface;

        return $this;
    }

    /**
     * Get surface.
     *
     * @return int
     */
    public function getSurface()
    {
        return $this->surface;
    }

    /**
     * @param Floor $floor
     *
     * @return Parcel
     */
    public function setFloor($floor)
    {
        $this->floor = $floor;

        return $this;
    }

    /**
     * Get surface.
     *
     * @return Floor
     */
    public function getFloor()
    {
        return $this->floor;
    }

    /**
     * @param \DateTime $disponibility
     *
     * @return Parcel
     */
    public function setDisponibility($disponibility)
    {
        $this->disponibility = $disponibility;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDisponibility()
    {
        return $this->disponibility;
    }
   
    /**
     * @param Type
     *
     * @return Parcel
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Date
     */
    public function getType()
    {
        return $this->type;
    }

    public function __toString()
    {
        return $this->getSurface().' m²';
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
    public function getDisponibilityToString()
    {
        if ($this->disponibility instanceof \DateTime) {
            return $this->disponibility->format('d/m/Y');
        }

        return 'Immédiate';
    }
}
