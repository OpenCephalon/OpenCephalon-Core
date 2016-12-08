<?php

namespace OpenCephalonBundle\Model;
use OpenCephalonBundle\Entity\SourceStream;


/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
abstract class  BaseItem {


    public abstract  function getTitle();
    public abstract  function getURL();

    public abstract  function getDescription();

    protected  abstract  function setDescription($description);

    /**
     * @return \DateTime
     */
    public abstract  function getPublishedDate();

    public function isValid() {
        return true;
    }

    public function processSourceStreamOptions(SourceStream $sourceStream) {
        if ($sourceStream->getDescriptionRemoveFromEnd()) {
            $str = $sourceStream->getDescriptionRemoveFromEnd();
            $str = strtolower(trim(str_replace('{{title}}', $this->getTitle(), $str)));

            $description = trim($this->getDescription());

            if (strtolower(substr($description, -strlen($str))) == $str) {
                $description = trim(substr($description, 0, -strlen($str)));
                $this->setDescription($description);
            }

        }
    }

}
