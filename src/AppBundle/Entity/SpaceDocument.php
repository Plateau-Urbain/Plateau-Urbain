<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpaceDocument
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class SpaceDocument
{
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Space", inversedBy="documents")
     * @ORM\JoinColumn(name="space_id", referencedColumnName="id")
     */
    protected $space;

    /**
     * @ORM\OneToMany(targetEntity="ApplicationFile", mappedBy="spaceDocument", cascade={"persist", "remove"})
     */
    private $files;

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
     * Set name
     *
     * @param string $name
     * @return SpaceDocument
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set space
     *
     * @param \AppBundle\Entity\Space $space
     * @return SpaceDocument
     */
    public function setSpace(\AppBundle\Entity\Space $space = null)
    {
        $this->space = $space;

        return $this;
    }

    /**
     * Get space
     *
     * @return \AppBundle\Entity\Space
     */
    public function getSpace()
    {
        return $this->space;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->files = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add files
     *
     * @param \AppBundle\Entity\ApplicationFile $files
     * @return SpaceDocument
     */
    public function addFile(\AppBundle\Entity\ApplicationFile $files)
    {
        $this->files[] = $files;

        return $this;
    }

    /**
     * Remove files
     *
     * @param \AppBundle\Entity\ApplicationFile $files
     */
    public function removeFile(\AppBundle\Entity\ApplicationFile $files)
    {
        $this->files->removeElement($files);
    }

    /**
     * Get files
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFiles()
    {
        return $this->files;
    }
}
