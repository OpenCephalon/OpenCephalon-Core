<?php

namespace OpenCephalonBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 * @ORM\Entity()
 * @ORM\Table(name="source_stream_to_out_stream_condition", uniqueConstraints={@ORM\UniqueConstraint(name="source_stream_to_out_stream_condition_public_id", columns={"source_stream_id", "out_stream_id", "public_id"})})
 * @ORM\HasLifecycleCallbacks
 */
class SourceStreamToOutStreamCondition
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
     * @ORM\ManyToOne(targetEntity="OpenCephalonBundle\Entity\SourceStream")
     * @ORM\JoinColumn(name="source_stream_id", referencedColumnName="id", nullable=false)
     */
    private $sourceStream;
    
    /**
     * @ORM\ManyToOne(targetEntity="OpenCephalonBundle\Entity\OutStream")
     * @ORM\JoinColumn(name="out_stream_id", referencedColumnName="id", nullable=false)
     */
    private $outStream;

    /**
     * @var string
     *
     * @ORM\Column(name="contains", type="string", length=250, nullable=true)
     */
    private $contains;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;



    public function isItemMatched(Item $item) {


        if ($this->contains) {

            if (stripos($item->getSearchText(), $this->contains) === false) {
                return false;
            }


        }

        return true;


    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId( $id ) {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getPublicId() {
        return $this->publicId;
    }

    /**
     * @param mixed $publicId
     */
    public function setPublicId( $publicId ) {
        $this->publicId = $publicId;
    }




    /**
     * @return string
     */
    public function getContains() {
        return $this->contains;
    }

    /**
     * @param string $contains
     */
    public function setContains( $contains ) {
        $this->contains = $contains;
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
     * @param mixed $outStream
     */
    public function setOutStream($outStream)
    {
        $this->outStream = $outStream;
    }

    /**
     * @return mixed
     */
    public function getOutStream()
    {
        return $this->outStream;
    }

    /**
     * @param mixed $sourceStream
     */
    public function setSourceStream($sourceStream)
    {
        $this->sourceStream = $sourceStream;
    }

    /**
     * @return mixed
     */
    public function getSourceStream()
    {
        return $this->sourceStream;
    }


    /**
     * @ORM\PrePersist()
     */
    public function beforeFirstSave() {
        $this->createdAt = new \DateTime("", new \DateTimeZone("UTC"));
    }



}
