<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Application
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ApplicationRepository")
 */
class Application
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
     * @ORM\Column(name="name", type="string")
     */
    private $name;


    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;



    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startOccupation", type="date")
     */
    private $startOccupation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endOccupation", type="date")
     */
    private $endOccupation;



    /**
     * @ORM\ManyToOne(
     *      targetEntity="Space"
     * )
     */
    private $space;


    /**
     * @ORM\ManyToOne(
     *      targetEntity="Category"
     * )
     */
    private $category;

    /**
     * @ORM\ManyToOne(
     *      targetEntity="User"
     * )
     */
    private $projectHolder;


    /**
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\File", mappedBy="application", orphanRemoval=true, cascade={"persist", "remove"})
     */
    protected $files;


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



    public function __construct()
    {
        $this->files = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setCreated(new \DateTime());
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
     * @return \DateTime
     */
    public function getEndOccupation()
    {
        return $this->endOccupation;
    }

    /**
     * @param \DateTime $endOccupation
     */
    public function setEndOccupation($endOccupation)
    {
        $this->endOccupation = $endOccupation;
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
     * Add pics.
     *
     * @param \AppBundle\Entity\SpaceImage $pics
     *
     * @return Space
     */
    public function addFile(File $file = null)
    {
        $this->setUpdated(new \DateTime());
        $this->files[] = $file;

        return $this;
    }

    /**
     * Remove pics.
     *
     * @param \AppBundle\Entity\SpaceImage $pics
     */
    public function removePic(File $file)
    {
        $this->setUpdated(new \DateTime());
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
     * @return mixed
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param mixed $files
     */
    public function setFiles($files)
    {
        $this->setUpdated(new \DateTime());
        $this->files = $files;
    }
}
