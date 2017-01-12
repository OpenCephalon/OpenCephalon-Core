<?php

namespace OpenCephalonBundle\Tests\Action;


use OpenCephalonBundle\Entity\OutStreamToTwitter;
use OpenCephalonBundle\Entity\Item;
use OpenCephalonBundle\Tests\BaseTest;


/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
class OutStreamTweetActionTest extends BaseTest {



    function dataForTestSet() {
        return array(
            array('News:','Test Title','http://google.com',
                'News: Test Title http://google.com'),
            array('','Test Title','http://google.com',
                'Test Title http://google.com'),
            array('','Test Title Long Test Title Long Test Title Long Test Title Long Test Title Long Test Title Long Test Title Long Test Title Long Test Title Long','http://google.com',
                'Test Title Long Test Title Long Test Title Long Test Title Long Test Title Long Test Title Long Test Title ... http://google.com'),
            array('News:','Test Title Long Test Title Long Test Title Long Test Title Long Test Title Long Test Title Long Test Title Long Test Title Long Test Title Long','http://google.com',
                'News: Test Title Long Test Title Long Test Title Long Test Title Long Test Title Long Test Title Long Test ... http://google.com'),
        );
    }

    /**
     * @dataProvider dataForTestSet
     */
    function testSet($contentPrefix, $title, $url, $tweet) {

        $item = new Item();
        $item->setTitle($title);
        $item->setURL($url);

        $outStreamToTwitter = new OutStreamToTwitter();
        $outStreamToTwitter->setContentPrefix($contentPrefix);

        $action = new OutStreamTweetActionWrapper($this->container);

        $this->assertEquals($tweet, $action->getTweetContentsWrapper($outStreamToTwitter, $item));


    }


}

