<?php

namespace OpenCephalonBundle\Tests\Action;

use OpenCephalonBundle\Action\OutStreamTweetAction;
use OpenCephalonBundle\Entity\OutStreamToTwitter;
use OpenCephalonBundle\Entity\Item;

class OutStreamTweetActionWrapper extends  OutStreamTweetAction {


    public function getTweetContentsWrapper( OutStreamToTwitter $outStreamToTwitter, Item $item ) {
        return $this->getTweetContents($outStreamToTwitter, $item);

    }

}