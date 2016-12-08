<?php

namespace OpenCephalonBundle\Tests\Model;

use OpenCephalonBundle\Entity\Item;
use OpenCephalonBundle\Entity\SourceStream;
use OpenCephalonBundle\Tests\BaseTest;
use OpenCephalonBundle\Entity\SourceStreamToOutStreamCondition;
use OpenCephalonBundle\Tests\DummyBaseItem;


/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
class BaseItemTest extends BaseTest {

    function dataForTestProcessSourceStreamOptionsDescriptionRemoveFromEnd() {
        return array(
            // With no placeholders
            array('Test','This is a test. This first appeared on a cat.', 'This first appeared on a cat.', 'This is a test.'),
            array('Test','    This is a test. This first appeared on a cat.', 'This first appeared on a cat.', 'This is a test.'),
            array('Test','This is a test. This first appeared on a cat.    ', 'This first appeared on a cat.', 'This is a test.'),
            array('Test','This is a test. This first appeared on a cat.', '    This first appeared on a cat.', 'This is a test.'),
            array('Test','This is a test. This first appeared on a cat.', 'This first appeared on a cat.    ', 'This is a test.'),
            array('Test','This is a test. This first appeared on a dog.', 'This first appeared on a cat.', 'This is a test. This first appeared on a dog.'),
            // With Title placeholder
            array('Test','This is a test. The post Test first appeared on a cat.', 'The post {{title}} first appeared on a cat.', 'This is a test.'),
            array('Test Bobby','This is a test. The post Test Bobby first appeared on a cat.', 'The post {{title}} first appeared on a cat.', 'This is a test.'),
            array('Test Bobby','This is a test. The post Test Bobby first appeared on a cat.', 'The post {{title}} first appeared on a cat.     ', 'This is a test.'),
            array('Test Bobby','This is a test. The post Test Bobby first appeared on a cat.', '     The post {{title}} first appeared on a cat.', 'This is a test.'),
            array('Test Bobby','    This is a test. The post Test Bobby first appeared on a cat.', 'The post {{title}} first appeared on a cat.', 'This is a test.'),
            array('Test Bobby','This is a test. The post Test Bobby first appeared on a cat.   ', 'The post {{title}} first appeared on a cat.', 'This is a test.'),
        );
    }

    /**
     * @dataProvider dataForTestProcessSourceStreamOptionsDescriptionRemoveFromEnd
     */
    function testProcessSourceStreamOptionsDescriptionRemoveFromEnd($title, $description, $removeFromEndOption, $newDescription) {

        $baseItem = new DummyBaseItem();
        $baseItem->setTitle($title);
        $baseItem->setDescription($description);

        $sourceSteam = new SourceStream();
        $sourceSteam->setDescriptionRemoveFromEnd($removeFromEndOption);

        $baseItem->processSourceStreamOptions($sourceSteam);

        $this->assertEquals($newDescription, $baseItem->getDescription());

    }

}
