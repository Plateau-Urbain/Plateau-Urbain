<?php
namespace AppBundle\Entity;

use Avocode\FormExtensionsBundle\Form\Model\UploadCollectionFileInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * File.
 *
 * @ORM\Table(name="file")
 * @ORM\Entity
 * @Vich\Uploadable
 */
class File implements UploadCollectionFileInterface
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
     * @ORM\ManyToOne(targetEntity="Application", inversedBy="files")
     * @ORM\JoinColumn(name="application_id", referencedColumnName="id")
     */
    protected $application;

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
        if ($file === null) {
            return;
        }
        $this->file = $file;
        return $this;
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
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @param mixed $application
     */
    public function setApplication($application)
    {
        $this->application = $application;
    }

    public function getSize()
    {
        return $this->file->getFileInfo()->getSize();
    }

    public function setParent($parent)
    {
        $this->setApplication($parent);
    }

    public function getPreview()
    {
        return (preg_match('/image\/.*/i', $this->file->getMimeType()));
    }


}
