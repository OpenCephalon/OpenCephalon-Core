<?php

namespace OpenCephalonBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 * @ORM\Entity()
 * @ORM\Table(name="source_stream_to_out_stream")
 * @ORM\HasLifecycleCallbacks
 */
class SourceStreamToOutStream
{

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="OpenCephalonBundle\Entity\SourceStream")
     * @ORM\JoinColumn(name="source_stream_id", referencedColumnName="id", nullable=false)
     */
    private $sourceStream;


    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="OpenCephalonBundle\Entity\OutStream")
     * @ORM\JoinColumn(name="out_stream_id", referencedColumnName="id", nullable=false)
     */
    private $outStream;



    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

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
