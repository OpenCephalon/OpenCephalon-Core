<?php

namespace OpenCephalonBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 * @ORM\Entity()
 * @ORM\Table(name="out_stream_has_item")
 * @ORM\HasLifecycleCallbacks
 */
class OutStreamHasItem
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="OpenCephalonBundle\Entity\OutStream")
     * @ORM\JoinColumn(name="out_stream_id", referencedColumnName="id", nullable=false)
     */
    private $outStream;


    /**
     * @ORM\ManyToOne(targetEntity="OpenCephalonBundle\Entity\Item")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id", nullable=false)
     */
    private $item;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="added_at", type="datetime", nullable=false)
     */
    private $addedAt;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="removed_at", type="datetime", nullable=true)
     */
    private $removedAt;

    /**
     * @ORM\ManyToOne(targetEntity="OpenCephalonBundle\Entity\User")
     * @ORM\JoinColumn(name="added_by_user_id", referencedColumnName="id", nullable=true)
     */
    private $addedByUser;

    /**
     * @ORM\ManyToOne(targetEntity="OpenCephalonBundle\Entity\User")
     * @ORM\JoinColumn(name="removed_by_user_id", referencedColumnName="id", nullable=true)
     */
    private $removedByUser;

    /**
     * @param mixed $addedAt
     */
    public function setAddedAt($addedAt)
    {
        $this->addedAt = $addedAt;
    }

    /**
     * @return mixed
     */
    public function getAddedAt()
    {
        return $this->addedAt;
    }

    /**
     * @param mixed $addedByUser
     */
    public function setAddedByUser($addedByUser)
    {
        $this->addedByUser = $addedByUser;
    }

    /**
     * @return mixed
     */
    public function getAddedByUser()
    {
        return $this->addedByUser;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \OpenCephalonBundle\Entity\datetime $removedAt
     */
    public function setRemovedAt($removedAt)
    {
        $this->removedAt = $removedAt;
    }

    /**
     * @return \OpenCephalonBundle\Entity\datetime
     */
    public function getRemovedAt()
    {
        return $this->removedAt;
    }

    /**
     * @param mixed $removedByUser
     */
    public function setRemovedByUser($removedByUser)
    {
        $this->removedByUser = $removedByUser;
    }

    /**
     * @return mixed
     */
    public function getRemovedByUser()
    {
        return $this->removedByUser;
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
    public function getOutStream() {
        return $this->outStream;
    }

    /**
     * @param mixed $outStream
     */
    public function setOutStream( $outStream ) {
        $this->outStream = $outStream;
    }




    /**
     * @ORM\PrePersist()
     */
    public function beforeFirstSave() {
        $this->addedAt = new \DateTime("", new \DateTimeZone("UTC"));
    }


}
