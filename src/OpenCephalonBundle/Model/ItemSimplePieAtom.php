<?php

namespace OpenCephalonBundle\Model;
use SimplePie_Item;


/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
class ItemSimplePieAtom extends BaseItem {


    /** @var  SimplePie_Item */
    protected $data;

    function __construct( SimplePie_Item $data ) {
        $this->data = $data;
    }


    public function getTitle() {
        return $this->data->get_title();
    }

    public function getURL() {
        return $this->data->get_link();
    }

    public function getDescription() {
        return strip_tags($this->data->get_description());
    }

    public function getPublishedDate() {
        return new \DateTime($this->data->get_date("c"));
    }

    public function getGuid() {
        return $this->data->get_id();
    }

}
