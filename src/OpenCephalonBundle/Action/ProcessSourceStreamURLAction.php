<?php


namespace OpenCephalonBundle\Action;

use OpenCephalonBundle\Entity\Item;
use OpenCephalonBundle\Entity\ItemFromSourceStream;
use OpenCephalonBundle\Entity\ItemIdAtom;
use OpenCephalonBundle\Entity\ItemIdRSS;
use OpenCephalonBundle\Entity\SourceStream;
use OpenCephalonBundle\Model\BaseItem;
use OpenCephalonBundle\Model\ItemRSS;
use OpenCephalonBundle\Model\ItemSimplePie;
use OpenCephalonBundle\Model\ItemSimplePieAtom;
use OpenCephalonBundle\Model\ItemSimplePieRSS;
use SimplePie;

/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
class ProcessSourceStreamURLAction
{

    protected $container;

    /** @var \GuzzleHttp\Client  */
    protected $guzzleClient;

    /** @var AddItemToStreamsAction */
    protected $addItemToStreamsAction;

    function __construct($container)
    {
        $this->container = $container;
        $this->guzzleClient = new \GuzzleHttp\Client();
        $this->addItemToStreamsAction = new AddItemToStreamsAction($container);
    }

    function go(SourceStream $sourceStream) {

        if (!$sourceStream->getIsActive()) {
            return;
        }

        $feed = new SimplePie();
        $feed->set_feed_url($sourceStream->getUrl());
        $feed->enable_cache(false);
        $feed->init();

        if ($feed->error) {
            // TODO Log!
            return;
        }

        foreach($feed->get_items() as $itemSimplePie) {

            if ($feed->get_type() & SIMPLEPIE_TYPE_RSS_ALL) {

                $item = new ItemSimplePieRSS( $itemSimplePie );
                if ( $item->isValid() ) {
                    $this->processModelItem( $sourceStream, $item );
                }

            } else if ($feed->get_type() & SIMPLEPIE_TYPE_ATOM_ALL) {

                $item = new ItemSimplePieAtom( $itemSimplePie );
                if ( $item->isValid() ) {
                    $this->processModelItem( $sourceStream, $item );
                }

            } else {


            }

        }

    }

    function processModelItem(SourceStream $sourceStream, BaseItem $modelItem) {

        $doctrine = $this->container->get('doctrine')->getEntityManager();
        $itemRepo = $doctrine->getRepository('OpenCephalonBundle:Item');
        $itemIdRSSRepo = $doctrine->getRepository('OpenCephalonBundle:ItemIdRSS');
        $itemIdAtomRepo = $doctrine->getRepository('OpenCephalonBundle:ItemIdAtom');
        $itemFromSourceStreamRepo = $doctrine->getRepository('OpenCephalonBundle:ItemFromSourceStream');

        // Work on base item
        $modelItem->processSourceStreamOptions($sourceStream);

        // Look for Item!
        $item = null;
        if ($modelItem instanceof ItemSimplePieRSS) {

            $itemId = $itemIdRSSRepo->findOneBy( array( 'guid'   => $modelItem->getGuid(),
                                                        'source' => $sourceStream->getSource()
                ) );
            if ( $itemId ) {
                $item = $itemId->getItem();
            }

        } else if ($modelItem instanceof ItemSimplePieAtom) {

            $itemId = $itemIdAtomRepo->findOneBy(array('guid'=>$modelItem->getGuid(),'source'=>$sourceStream->getSource()));
            if ($itemId) {
                $item = $itemId->getItem();
            }

        } else {
            throw new \Exception('This should never happen');
        }



        // Now Save or Update.
        if ($item == null) {
            $item = new Item();
            $item->setProject($sourceStream->getSource()->getProject());
            $item->setFromModel($modelItem);

            // If new Item, Create ID for it!
            $itemId = null;
            if ($modelItem instanceof ItemSimplePieRSS) {
                $itemId = new ItemIdRSS();
                $itemId->setItem($item);
                $itemId->setSource($sourceStream->getSource());
                $itemId->setGuid($modelItem->getGuid());
            } else if ($modelItem instanceof ItemSimplePieAtom) {
                $itemId = new ItemIdAtom();
                $itemId->setItem($item);
                $itemId->setSource($sourceStream->getSource());
                $itemId->setGuid($modelItem->getGuid());
            } else {
                throw new \Exception('This should never happen');
            }

            $doctrine->persist($item);
            $doctrine->persist($itemId);
            $doctrine->flush(array($item, $itemId));

            $this->writeItemFromSourceStreamRecord($item, $sourceStream);

        } else {
            $item->setFromModel($modelItem);
            $doctrine->persist($item);
            $doctrine->flush($item);

            // is there a $itemFromSourceStream record for this item and sourcestream?
            // If yes, Edit. If not, add it!
            $itemFromSourceStream = $itemFromSourceStreamRepo->findOneBy(array('item'=>$item, 'sourceStream'=>$sourceStream));
            if ($itemFromSourceStream) {
                $itemFromSourceStream->setLastSeenAt(new \DateTime());
                $doctrine->persist($itemFromSourceStream);
                $doctrine->flush($itemFromSourceStream);
            } else {
                $this->writeItemFromSourceStreamRecord($item, $sourceStream);
            }
        }

        $this->addItemToStreamsAction->go($sourceStream, $item);

    }

    protected function writeItemFromSourceStreamRecord(Item $item, SourceStream $sourceStream) {
        $doctrine = $this->container->get('doctrine')->getEntityManager();
        $itemFromSourceStream = new ItemFromSourceStream();
        $itemFromSourceStream->setSourceStream($sourceStream);
        $itemFromSourceStream->setItem($item);
        $doctrine->persist($itemFromSourceStream);
        $doctrine->flush($itemFromSourceStream);

    }

}
