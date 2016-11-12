<?php

namespace OpenCephalonBundle\Tests;
use OpenCephalonBundle\Model\BaseItem;


/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
class DummyBaseItem extends BaseItem {


    protected $title;

    protected $url;

    protected $description;

    protected $publishedDate;

    /**
     * @return mixed
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription( $description ) {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getPublishedDate() {
        return $this->publishedDate;
    }

    /**
     * @param mixed $publishedDate
     */
    public function setPublishedDate( $publishedDate ) {
        $this->publishedDate = $publishedDate;
    }

    /**
     * @return mixed
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle( $title ) {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getURL() {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setURL( $url ) {
        $this->url = $url;
    }






}
