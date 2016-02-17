<?php

namespace AppBundle\Entity;

use Avocode\FormExtensionsBundle\Form\Model\UploadCollectionFileInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * UserDocument
 *
 * @ORM\Table()
 * @ORM\Entity
 * @Vich\Uploadable
 */
class UserDocument
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
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @Assert\File(
     *     maxSize="5M"
     * )
     * @Assert\File(
     *      maxSize="5242880",
     *      mimeTypes = {
     *          "image/png",
     *          "image/jpeg",
     *          "image/jpg",
     *          "application/pdf",
     *          "application/x-pdf",
     *          "application/msword"
     *      }
     * )
     * @Vich\UploadableField(mapping="file", fileNameProperty="fileName")
     */
    private $file;

    /**
     * @var string
     *
     * @ORM\Column(name="fileName", type="string", nullable=true)
     */
    private $fileName;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="documents")
     */
    protected $projectHolder;

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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return UserDocument
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set file
     *
     * @param string $file
     * @return UserDocument
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set fileName
     *
     * @param string $fileName
     * @return UserDocument
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return UserDocument
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set projectHolder
     *
     * @param \AppBundle\Entity\User $projectHolder
     * @return UserDocument
     */
    public function setProjectHolder(\AppBundle\Entity\User $projectHolder = null)
    {
        $this->projectHolder = $projectHolder;

        return $this;
    }

    /**
     * Get projectHolder
     *
     * @return \AppBundle\Entity\User 
     */
    public function getProjectHolder()
    {
        return $this->projectHolder;
    }
}
