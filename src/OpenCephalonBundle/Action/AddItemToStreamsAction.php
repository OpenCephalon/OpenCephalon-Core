<?php


namespace OpenCephalonBundle\Action;

use OpenCephalonBundle\Entity\Item;
use OpenCephalonBundle\Entity\OutStreamHasItem;
use OpenCephalonBundle\Entity\SourceStream;

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
            if (!$itemRepo->wasItemEverInOutStream($item, $sourceStreamToOutStream->getOutStream())) {

                $outStreamHasItem = new OutStreamHasItem();
                $outStreamHasItem->setOutStream($sourceStreamToOutStream->getOutStream());
                $outStreamHasItem->setItem($item);

                $doctrine->persist($outStreamHasItem);
                $doctrine->flush($outStreamHasItem);

            }
        }

    }

}

