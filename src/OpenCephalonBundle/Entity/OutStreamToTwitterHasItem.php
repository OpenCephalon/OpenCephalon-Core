<?php

namespace OpenCephalonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 * @ORM\Entity()
 * @ORM\Table(name="out_stream_to_twitter_has_item")
 * @ORM\HasLifecycleCallbacks
 */
class OutStreamToTwitterHasItem
{

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="OpenCephalonBundle\Entity\Item")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id", nullable=false)
     */
    private $item;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="OpenCephalonBundle\Entity\OutStreamToTwitter")
     * @ORM\JoinColumn(name="out_stream_to_twitter_id", referencedColumnName="id", nullable=false)
     */
    private $outStreamToTwitter;


    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;


    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="tweeted_at", type="datetime", nullable=true)
     */
    private $tweetedAt;


    /**
     * @var string
     *
     * @ORM\Column(name="tweet_id", type="string", length=250, nullable=true)
     */
    private $tweetId;

    /**
     * @return datetime
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * @param datetime $createdAt
     */
    public function setCreatedAt( $createdAt ) {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getItem() {
        return $this->item;
    }

    /**
     * @param mixed $item
     */
    public function setItem( $item ) {
        $this->item = $item;
    }

    /**
     * @return mixed
     */
    public function getOutStreamToTwitter() {
        return $this->outStreamToTwitter;
    }

    /**
     * @param mixed $outStreamToTwitter
     */
    public function setOutStreamToTwitter( $outStreamToTwitter ) {
        $this->outStreamToTwitter = $outStreamToTwitter;
    }

    /**
     * @return string
     */
    public function getTweetId() {
        return $this->tweetId;
    }

    /**
     * @param string $tweet_id
     */
    public function setTweetId( $tweet_id ) {
        $this->tweetId = $tweet_id;
    }

    /**
     * @return datetime
     */
    public function getTweetedAt() {
        return $this->tweetedAt;
    }

    /**
     * @param datetime $tweetedAt
     */
    public function setTweetedAt( $tweetedAt ) {
        $this->tweetedAt = $tweetedAt;
    }



    /**
     * @ORM\PrePersist()
     */
    public function beforeFirstSave() {
        $this->createdAt = new \DateTime("", new \DateTimeZone("UTC"));
    }




}