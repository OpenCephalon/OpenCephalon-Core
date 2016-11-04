<?php


namespace OpenCephalonBundle\Action;

use OpenCephalonBundle\Entity\Item;
use OpenCephalonBundle\Entity\OutStreamHasItem;
use OpenCephalonBundle\Entity\SourceStream;
use OpenCephalonBundle\Entity\SourceStreamToOutStream;
use OpenCephalonBundle\Entity\SourceStreamToOutStreamCondition;

/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
class AddItemToStreamsAction
{


    protected $container;


    function __construct($container)
    {
        $this->container = $container;
    }

    public function go(SourceStream $sourceStream, Item $item) {

        $doctrine = $this->container->get('doctrine')->getEntityManager();
        $sourceStreamToOutStreamRepo = $doctrine->getRepository('OpenCephalonBundle:SourceStreamToOutStream');
        $itemRepo = $doctrine->getRepository('OpenCephalonBundle:Item');

        foreach($sourceStreamToOutStreamRepo->findBy(array('sourceStream'=>$sourceStream )) as $sourceStreamToOutStream) {

            // If Item was in a stream and was removed, don't put it back. Manual editors know better.
            // and check conditions
            if (!$itemRepo->wasItemEverInOutStream($item, $sourceStreamToOutStream->getOutStream())
                && $this->doesItemPassSourceStreamConditions($item, $sourceStreamToOutStream)) {

                $outStreamHasItem = new OutStreamHasItem();
                $outStreamHasItem->setOutStream($sourceStreamToOutStream->getOutStream());
                $outStreamHasItem->setItem($item);

                $doctrine->persist($outStreamHasItem);
                $doctrine->flush($outStreamHasItem);

            }
        }

    }

    protected function doesItemPassSourceStreamConditions(Item $item, SourceStreamToOutStream $sourceStreamToOutStream) {

        $doctrine = $this->container->get('doctrine')->getEntityManager();
        $conditions = $doctrine->getRepository('OpenCephalonBundle:SourceStreamToOutStreamCondition')->findBy(array('sourceStream'=>$sourceStreamToOutStream->getSourceStream(), 'outStream'=>$sourceStreamToOutStream->getOutStream()));
        if (count($conditions) == 0) {
            return true;
        }

        foreach($conditions as $condition) {
            if ($condition->isItemMatched($item)) {
                return true;
            }
        }

        return false;

    }

}

