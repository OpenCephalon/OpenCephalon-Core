<?php

namespace OpenCephalonBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 * @ORM\Entity()
 * @ORM\Table(name="item_from_source_stream")
 * @ORM\HasLifecycleCallbacks
 */
class ItemFromSourceStream
{


    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="OpenCephalonBundle\Entity\SourceStream")
     * @ORM\JoinColumn(name="source_stream_id", referencedColumnName="id", nullable=false)
     */
    private $sourceStream;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="OpenCephalonBundle\Entity\Item")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id", nullable=false)
     */
    private $item;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;


    /**
     * @var datetime $publishedAt
     *
     * @ORM\Column(name="last_seen_at", type="datetime", nullable=false)
     */
    private $lastSeenAt;

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
     * @param mixed $item
     */
    public function setItem($item)
    {
        $this->item = $item;
    }

    /**
     * @return mixed
     */
    public function getItem()
    {
        return $this->item;
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
     * @return datetime
     */
    public function getLastSeenAt() {
        return $this->lastSeenAt;
    }

    /**
     * @param datetime $lastSeenAt
     */
    public function setLastSeenAt( $lastSeenAt ) {
        $this->lastSeenAt = $lastSeenAt;
    }



    /**
     * @ORM\PrePersist()
     */
    public function beforeFirstSave() {
        $this->createdAt = new \DateTime("", new \DateTimeZone("UTC"));
        $this->lastSeenAt = new \DateTime("", new \DateTimeZone("UTC"));
    }


}
