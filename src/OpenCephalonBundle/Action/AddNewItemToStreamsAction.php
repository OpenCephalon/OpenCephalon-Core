<?php


namespace OpenCephalonBundle\Action;

use OpenCephalonBundle\Entity\Item;
use OpenCephalonBundle\Entity\OutStreamHasItem;

/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
class AddNewItemToStreamsAction
{


    protected $container;


    function __construct($container)
    {
        $this->container = $container;
    }

    public function go(Item $item) {

        $doctrine = $this->container->get('doctrine')->getEntityManager();
        $sourceStreamToOutStreamRepo = $doctrine->getRepository('OpenCephalonBundle:SourceStreamToOutStream');

        foreach($sourceStreamToOutStreamRepo->findBy(array('sourceStream'=>$item->getSourceStream() )) as $sourceStreamToOutStream) {

            $outStreamHasItem = new OutStreamHasItem();
            $outStreamHasItem->setOutStream($sourceStreamToOutStream->getOutStream());
            $outStreamHasItem->setItem($item);

            $doctrine->persist($outStreamHasItem);
            $doctrine->flush($outStreamHasItem);
        }


    }

}

