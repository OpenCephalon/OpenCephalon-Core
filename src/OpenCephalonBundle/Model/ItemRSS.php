<?php

namespace OpenCephalonBundle\Model;



/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
class ItemRSS extends BaseItem {


    protected $data;

    function __construct($data)
    {
        $this->data = $data;
    }

    public function getTitle()
    {
        return $this->data->title;
    }

    public function getURL()
    {
        return $this->data->link;
    }


    public function getDescription()
    {
        return strip_tags( html_entity_decode($this->data->description));
    }

    public function getPublishedDate()
    {
        return new \DateTime($this->data->pubDate);
    }

    public function getGuid() {
        return $this->data->guid;
    }

}
