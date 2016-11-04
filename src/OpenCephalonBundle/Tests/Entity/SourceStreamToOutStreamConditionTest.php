<?php

namespace OpenCephalonBundle\Tests\Entity;

use OpenCephalonBundle\Entity\Item;
use OpenCephalonBundle\Tests\BaseTest;
use OpenCephalonBundle\Entity\SourceStreamToOutStreamCondition;


/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
class SourceStreamToOutStreamConditionTest extends BaseTest {


    function testNull1() {

        $sourceStreamToOutStreamCondition = new  SourceStreamToOutStreamCondition();


        $item = new Item();

        // It's unclear what the result should be here.
        // But I want a clearly defined and tested unclear result, damn it!

        $this->assertTrue($sourceStreamToOutStreamCondition->isItemMatched($item));

    }


    function testContainsInTitle1() {

        $sourceStreamToOutStreamCondition = new  SourceStreamToOutStreamCondition();
        $sourceStreamToOutStreamCondition->setContains('cat');

        $item = new Item();
        $item->setTitle('the cat sat on the mat');

        $this->assertTrue($sourceStreamToOutStreamCondition->isItemMatched($item));

    }

    function testContainsInTitle2() {

        $sourceStreamToOutStreamCondition = new  SourceStreamToOutStreamCondition();
        $sourceStreamToOutStreamCondition->setContains('CAT');

        $item = new Item();
        $item->setTitle('the cat sat on the mat');

        $this->assertTrue($sourceStreamToOutStreamCondition->isItemMatched($item));

    }


    function testContainsInDescription1() {

        $sourceStreamToOutStreamCondition = new  SourceStreamToOutStreamCondition();
        $sourceStreamToOutStreamCondition->setContains('cat');

        $item = new Item();
        $item->setDescription('the cat sat on the mat');

        $this->assertTrue($sourceStreamToOutStreamCondition->isItemMatched($item));

    }


    function testContainsInDescription2() {

        $sourceStreamToOutStreamCondition = new  SourceStreamToOutStreamCondition();
        $sourceStreamToOutStreamCondition->setContains('CAT');

        $item = new Item();
        $item->setDescription('the cat sat on the mat');

        $this->assertTrue($sourceStreamToOutStreamCondition->isItemMatched($item));

    }

    function testDoesNotContain1() {

        $sourceStreamToOutStreamCondition = new  SourceStreamToOutStreamCondition();
        $sourceStreamToOutStreamCondition->setContains('lizard');

        $item = new Item();
        $item->setDescription('the cat sat on the mat');

        $this->assertFalse($sourceStreamToOutStreamCondition->isItemMatched($item));

    }

}
