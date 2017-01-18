<?php

namespace OpenCephalonBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 * @ORM\Entity()
 * @ORM\Table(name="item_from_source")
 * @ORM\HasLifecycleCallbacks
 */
class ItemFromSource
{


    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="OpenCephalonBundle\Entity\Source")
     * @ORM\JoinColumn(name="source_id", referencedColumnName="id", nullable=false)
     */
    private $source;

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
     * @return mixed
     */
    public function getSource() {
        return $this->source;
    }

    /**
     * @param mixed $source
     */
    public function setSource( $source ) {
        $this->source = $source;
    }


    /**
     * @ORM\PrePersist()
     */
    public function beforeFirstSave() {
        $this->createdAt = new \DateTime("", new \DateTimeZone("UTC"));
    }


}
