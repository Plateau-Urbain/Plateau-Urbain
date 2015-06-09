<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $surface;

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
}
