<?php

namespace OpenCephalonBundle\Model;



/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
abstract class  BaseItem {


    public abstract  function getTitle();
    public abstract  function getURL();

    public abstract  function getDescription();

    public abstract  function getPublishedDate();

    public function isValid() {
        return true;
    }
}
