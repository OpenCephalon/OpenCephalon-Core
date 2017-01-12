<?php

namespace OpenCephalonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 * @ORM\Entity(repositoryClass="OpenCephalonBundle\Repository\OutStreamToTwitterRepository")
 * @ORM\Table(name="out_stream_to_twitter", uniqueConstraints={@ORM\UniqueConstraint(name="out_stream_to_twitter_public_id", columns={"out_stream_id", "public_id"})})
 * @ORM\HasLifecycleCallbacks
 */
class OutStreamToTwitter
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
     * @ORM\Column(name="public_id", type="string", length=250, unique=false, nullable=false)
     * @Assert\NotBlank()
     */
    private $publicId;

    /**
     * @var string
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=false)
     */
    private $isActive;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;


    /**
     * @var string
     *
     * @ORM\Column(name="access_token", type="string", length=250, nullable=false)
     */
    private $access_token;


    /**
     * @var string
     *
     * @ORM\Column(name="access_token_secret", type="string", length=250, nullable=false)
     */
    private $access_token_secret;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter_id", type="string", length=250, nullable=false)
     */
    private $twitter_id;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter_username", type="string", length=250, nullable=false)
     */
    private $twitter_username;

    /**
     * @var string
     *
     * @ORM\Column(name="content_prefix", type="string", length=250, nullable=false)
     */
    private $content_prefix;

    /**
     * @var string
     *
     * @ORM\Column(name="mins_after_tweet_before_next_tweet", type="smallint", nullable=false)
     */
    private $minsAfterTweetBeforeNextTweet;



    /**
     * @var string
     *
     * @ORM\Column(name="mon_post_after", type="smallint", nullable=false)
     */
    private $monPostAfter;

    /**
     * @var string
     *
     * @ORM\Column(name="mon_post_before", type="smallint", nullable=false)
     */
    private $monPostBefore;


    /**
     * @var string
     *
     * @ORM\Column(name="tue_post_after", type="smallint", nullable=false)
     */
    private $tuePostAfter;

    /**
     * @var string
     *
     * @ORM\Column(name="tue_post_before", type="smallint", nullable=false)
     */
    private $tuePostBefore;



    /**
     * @var string
     *
     * @ORM\Column(name="wed_post_after", type="smallint", nullable=false)
     */
    private $wedPostAfter;

    /**
     * @var string
     *
     * @ORM\Column(name="wed_post_before", type="smallint", nullable=false)
     */
    private $wedPostBefore;



    /**
     * @var string
     *
     * @ORM\Column(name="thu_post_after", type="smallint", nullable=false)
     */
    private $thuPostAfter;

    /**
     * @var string
     *
     * @ORM\Column(name="thu_post_before", type="smallint", nullable=false)
     */
    private $thuPostBefore;



    /**
     * @var string
     *
     * @ORM\Column(name="fri_post_after", type="smallint", nullable=false)
     */
    private $friPostAfter;

    /**
     * @var string
     *
     * @ORM\Column(name="fri_post_before", type="smallint", nullable=false)
     */
    private $friPostBefore;



    /**
     * @var string
     *
     * @ORM\Column(name="sat_post_after", type="smallint", nullable=false)
     */
    private $satPostAfter;

    /**
     * @var string
     *
     * @ORM\Column(name="sat_post_before", type="smallint", nullable=false)
     */
    private $satPostBefore;



    /**
     * @var string
     *
     * @ORM\Column(name="sun_post_after", type="smallint", nullable=false)
     */
    private $sunPostAfter;

    /**
     * @var string
     *
     * @ORM\Column(name="sun_post_before", type="smallint", nullable=false)
     */
    private $sunPostBefore;

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
    public function getAccessToken() {
        return $this->access_token;
    }

    /**
     * @param string $access_token
     */
    public function setAccessToken( $access_token ) {
        $this->access_token = $access_token;
    }

    /**
     * @return string
     */
    public function getAccessTokenSecret() {
        return $this->access_token_secret;
    }

    /**
     * @param string $access_token_secret
     */
    public function setAccessTokenSecret( $access_token_secret ) {
        $this->access_token_secret = $access_token_secret;
    }

    /**
     * @return string
     */
    public function getContentPrefix() {
        return trim($this->content_prefix);
    }

    /**
     * @return string
     */
    public function hasContentPrefix() {
        return (boolean)trim($this->content_prefix);
    }

    /**
     * @param string $content_prefix
     */
    public function setContentPrefix( $content_prefix ) {
        $this->content_prefix = $content_prefix;
    }

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
     * @return string
     */
    public function getFriPostAfter() {
        return $this->friPostAfter;
    }

    /**
     * @param string $friPostAfter
     */
    public function setFriPostAfter( $friPostAfter ) {
        $this->friPostAfter = $friPostAfter;
    }

    /**
     * @return string
     */
    public function getFriPostBefore() {
        return $this->friPostBefore;
    }

    /**
     * @param string $friPostBefore
     */
    public function setFriPostBefore( $friPostBefore ) {
        $this->friPostBefore = $friPostBefore;
    }

    /**
     * @return string
     */
    public function getMonPostAfter() {
        return $this->monPostAfter;
    }

    /**
     * @param string $monPostAfter
     */
    public function setMonPostAfter( $monPostAfter ) {
        $this->monPostAfter = $monPostAfter;
    }

    /**
     * @return string
     */
    public function getMonPostBefore() {
        return $this->monPostBefore;
    }

    /**
     * @param string $monPostBefore
     */
    public function setMonPostBefore( $monPostBefore ) {
        $this->monPostBefore = $monPostBefore;
    }

    /**
     * @return string
     */
    public function getSatPostAfter() {
        return $this->satPostAfter;
    }

    /**
     * @param string $satPostAfter
     */
    public function setSatPostAfter( $satPostAfter ) {
        $this->satPostAfter = $satPostAfter;
    }

    /**
     * @return string
     */
    public function getSatPostBefore() {
        return $this->satPostBefore;
    }

    /**
     * @param string $satPostBefore
     */
    public function setSatPostBefore( $satPostBefore ) {
        $this->satPostBefore = $satPostBefore;
    }

    /**
     * @return string
     */
    public function getSunPostAfter() {
        return $this->sunPostAfter;
    }

    /**
     * @param string $sunPostAfter
     */
    public function setSunPostAfter( $sunPostAfter ) {
        $this->sunPostAfter = $sunPostAfter;
    }

    /**
     * @return string
     */
    public function getSunPostBefore() {
        return $this->sunPostBefore;
    }

    /**
     * @param string $sunPostBefore
     */
    public function setSunPostBefore( $sunPostBefore ) {
        $this->sunPostBefore = $sunPostBefore;
    }

    /**
     * @return string
     */
    public function getThuPostAfter() {
        return $this->thuPostAfter;
    }

    /**
     * @param string $thuPostAfter
     */
    public function setThuPostAfter( $thuPostAfter ) {
        $this->thuPostAfter = $thuPostAfter;
    }

    /**
     * @return string
     */
    public function getThuPostBefore() {
        return $this->thuPostBefore;
    }

    /**
     * @param string $thuPostBefore
     */
    public function setThuPostBefore( $thuPostBefore ) {
        $this->thuPostBefore = $thuPostBefore;
    }

    /**
     * @return string
     */
    public function getTuePostAfter() {
        return $this->tuePostAfter;
    }

    /**
     * @param string $tuePostAfter
     */
    public function setTuePostAfter( $tuePostAfter ) {
        $this->tuePostAfter = $tuePostAfter;
    }

    /**
     * @return string
     */
    public function getTuePostBefore() {
        return $this->tuePostBefore;
    }

    /**
     * @param string $tuePostBefore
     */
    public function setTuePostBefore( $tuePostBefore ) {
        $this->tuePostBefore = $tuePostBefore;
    }

    /**
     * @return string
     */
    public function getTwitterId() {
        return $this->twitter_id;
    }

    /**
     * @param string $twitter_id
     */
    public function setTwitterId( $twitter_id ) {
        $this->twitter_id = $twitter_id;
    }



    /**
     * @return string
     */
    public function getTwitterUsername() {
        return $this->twitter_username;
    }

    /**
     * @param string $twitter_username
     */
    public function setTwitterUsername( $twitter_username ) {
        $this->twitter_username = $twitter_username;
    }

    /**
     * @return string
     */
    public function getWedPostAfter() {
        return $this->wedPostAfter;
    }

    /**
     * @param string $wedPostAfter
     */
    public function setWedPostAfter( $wedPostAfter ) {
        $this->wedPostAfter = $wedPostAfter;
    }

    /**
     * @return string
     */
    public function getWedPostBefore() {
        return $this->wedPostBefore;
    }

    /**
     * @param string $wedPostBefore
     */
    public function setWedPostBefore( $wedPostBefore ) {
        $this->wedPostBefore = $wedPostBefore;
    }

    /**
     * @return string
     */
    public function getMinsAfterTweetBeforeNextTweet() {
        return $this->minsAfterTweetBeforeNextTweet;
    }

    /**
     * @param string $minsAfterTweetBeforeNextTweet
     */
    public function setMinsAfterTweetBeforeNextTweet( $minsAfterTweetBeforeNextTweet ) {
        $this->minsAfterTweetBeforeNextTweet = $minsAfterTweetBeforeNextTweet;
    }



    /**
     * @ORM\PrePersist()
     */
    public function beforeFirstSave() {
        $this->createdAt = new \DateTime("", new \DateTimeZone("UTC"));
    }

}
