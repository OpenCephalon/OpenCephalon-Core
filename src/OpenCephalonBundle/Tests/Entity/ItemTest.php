<?php

namespace OpenCephalonBundle\Tests\Entity;

use OpenCephalonBundle\Entity\Item;
use OpenCephalonBundle\Tests\BaseTest;
use OpenCephalonBundle\Entity\SourceStreamToOutStreamCondition;
use OpenCephalonBundle\Tests\DummyBaseItem;


/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
class ItemTest extends BaseTest {

    function testSetEffectivePublishedAt1() {

        $now = new \DateTime();

        $baseItem = new DummyBaseItem();
        $baseItem->setPublishedDate($now);

        $item = new Item();
        // Don't set created at, this is on first save
        $item->setFromModel($baseItem);

        $this->assertEquals($now->format('Y'),  $item->getEffectivePublishedAt()->format('Y'));
        $this->assertFalse($item->isEffectivePublishedAtDifferent());

    }

    function testSetEffectivePublishedAt2() {

        $now = new \DateTime();

        $baseItem = new DummyBaseItem();
        $baseItem->setPublishedDate($now);

        $item = new Item();
        $item->setCreatedAt($now);
        $item->setFromModel($baseItem);

        $this->assertEquals($now->format('Y'),  $item->getEffectivePublishedAt()->format('Y'));
        $this->assertFalse($item->isEffectivePublishedAtDifferent());

    }

    function testSetEffectivePublishedAtWithFutureDate1() {

        $now = new \DateTime();
        $now->setDate(2030,1,1);

        $baseItem = new DummyBaseItem();
        $baseItem->setPublishedDate($now);

        $item = new Item();
        // Don't set created at, this is on first save
        $item->setFromModel($baseItem);

        $this->assertNotEquals($now->format('Y'),  $item->getEffectivePublishedAt()->format('Y'));
        $this->assertTrue($item->isEffectivePublishedAtDifferent());

    }


    function testSetEffectivePublishedAtWithFutureDate2() {

        $pub = new \DateTime();
        $pub->setDate(2030,1,1);

        $baseItem = new DummyBaseItem();
        $baseItem->setPublishedDate($pub);

        $item = new Item();
        $item->setCreatedAt(new \DateTime());
        $item->setFromModel($baseItem);

        $this->assertNotEquals($pub->format('Y'),  $item->getEffectivePublishedAt()->format('Y'));
        $this->assertTrue($item->isEffectivePublishedAtDifferent());

    }


}
