<?php

namespace OpenCephalonBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 * @ORM\Entity(repositoryClass="OpenCephalonBundle\Repository\SourceStreamRepository")
 * @ORM\Table(name="source_stream", uniqueConstraints={@ORM\UniqueConstraint(name="source_stream_public_id", columns={"source_id", "public_id"})})
 * @ORM\HasLifecycleCallbacks
 */
class SourceStream
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="public_id", type="string", length=250, unique=false, nullable=false)
     * @Assert\NotBlank()
     */
    private $publicId;


    /**
     * @ORM\ManyToOne(targetEntity="OpenCephalonBundle\Entity\Source")
     * @ORM\JoinColumn(name="source_id", referencedColumnName="id", nullable=false)
     */
    private $source;


    /**
     * @var string
     *
     * @ORM\Column(name="url", type="text", nullable=false)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="user_agent", type="text", nullable=true)
     */
    private $userAgent;

    /**
     * @var string
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=false, options={"default" : true})
     */
    private $isActive;

    /**
     * @var string
     *
     * @ORM\Column(name="description_remove_from_end", type="text", nullable=true)
     */
    private $descriptionRemoveFromEnd;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;


    /**
     * @ORM\OneToMany(targetEntity="OpenCephalonBundle\Entity\ItemFromSourceStream", mappedBy="sourceStream")
     */
    private $itemFromSourceStreams;



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param \OpenCephalonBundle\Entity\datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \OpenCephalonBundle\Entity\datetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $source
     */
    public function setSource($source)
    {
        $this->source = $source;
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return string
     */
    public function getDescriptionRemoveFromEnd() {
        return $this->descriptionRemoveFromEnd;
    }

    /**
     * @param string $descriptionRemoveFromEnd
     */
    public function setDescriptionRemoveFromEnd( $descriptionRemoveFromEnd ) {
        $this->descriptionRemoveFromEnd = $descriptionRemoveFromEnd;
    }




    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getUserAgent() {
        return $this->userAgent;
    }

    /**
     * @param string $userAgent
     */
    public function setUserAgent( $userAgent ) {
        $this->userAgent = $userAgent;
    }

    /**
     * @param mixed $publicId
     */
    public function setPublicId($publicId)
    {
        $this->publicId = $publicId;
    }

    /**
     * @return mixed
     */
    public function getPublicId()
    {
        return $this->publicId;
    }

    /**
     * @return string
     */
    public function getIsActive() {
        return $this->isActive;
    }

    /**
     * @param string $isActive
     */
    public function setIsActive( $isActive ) {
        $this->isActive = $isActive;
    }



    /**
     * @ORM\PrePersist()
     */
    public function beforeFirstSave() {
        $this->createdAt = new \DateTime("", new \DateTimeZone("UTC"));
    }

}
