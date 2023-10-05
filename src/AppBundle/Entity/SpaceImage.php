<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;

/**
 * SpaceImage
 *
 * @ORM\Table(name="space_image")
 * @ORM\Entity(repositoryClass="Gedmo\Sortable\Entity\Repository\SortableRepository")
 * @Vich\Uploadable
 */
class SpaceImage
{
    const FILETYPE_DOCUMENT = 'document';
    const FILETYPE_IMAGE = 'image';

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Assert\File(
     *     maxSize="20M"
     * )
     * @Vich\UploadableField(mapping="file", fileNameProperty="fileName")
     */
    protected $file;

    /**
     * @ORM\Column(name="file_name", type="string", nullable=true)
     */
    protected $fileName;

    /**
     * @var int
     *
     * @ORM\Column(name="file_type", type="string")
     */
    protected $fileType;

    /**
     * @ORM\ManyToOne(targetEntity="Space", inversedBy="pics")
     * @ORM\JoinColumn(name="space_id", referencedColumnName="id")
     * @Gedmo\SortableGroup
     */
    protected $space;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="smallint")
     * @Gedmo\SortablePosition
     */
    protected $position;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile(File $file = null)
    {
        $this->file = $file;

        if ($file) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return mixed
     */
    public function getFileType()
    {
        return ($this->fileType) ?: self::FILETYPE_IMAGE;
    }

    /**
     * @param mixed $fileType
     */
    public function setFileType($fileType)
    {
        $this->fileType = $fileType;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param mixed $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
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

    public function getSize()
    {
        return $this->file->getFileInfo()->getSize();
    }

    public function setParent($parent)
    {
        $this->setSpace($parent);
    }

    public function getPreview()
    {
        return (preg_match('/image\/.*/i', $this->file->getMimeType()));
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
}
