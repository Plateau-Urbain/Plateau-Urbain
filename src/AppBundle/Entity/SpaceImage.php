<?php

namespace AppBundle\Entity;

use Avocode\FormExtensionsBundle\Form\Model\UploadCollectionFileInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * SpaceImage.
 *
 * @ORM\Table(name="space_image")
 * @ORM\Entity
 * @Vich\Uploadable
 */
class SpaceImage implements UploadCollectionFileInterface
{
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
     * @ORM\ManyToOne(targetEntity="Space", inversedBy="pics")
     * @ORM\JoinColumn(name="space_id", referencedColumnName="id")
     */
    protected $space;

    /**
     * @ORM\Column(type="datetime")
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
    public function setFile(\Symfony\Component\HttpFoundation\File\File $file = null)
    {
        $this->file = $file;

        if ($file) {
            $this->updatedAt = new \DateTime('now');
        }
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
}
