<?php


namespace OpenCephalonBundle\Action;

use OpenCephalonBundle\Entity\Item;
use OpenCephalonBundle\Entity\ItemFromSourceStream;
use OpenCephalonBundle\Entity\ItemIdRSS;
use OpenCephalonBundle\Entity\SourceStream;
use OpenCephalonBundle\Model\BaseItem;
use OpenCephalonBundle\Model\ItemRSS;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

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

        $res = $this->guzzleClient->request('GET', $sourceStream->getURL(), array());

        if ($res->getStatusCode() == 200) {

            $data = new \SimpleXMLElement($res->getBody());

            foreach($data->channel->item as $dataItem) {

                $itemRSS = new ItemRSS($dataItem);
                if ($itemRSS->isValid()) {
                    $this->processModelItem($sourceStream, $itemRSS);
                }

            }

        }

    }

    function processModelItem(SourceStream $sourceStream, BaseItem $modelItem) {

        $doctrine = $this->container->get('doctrine')->getEntityManager();
        $itemRepo = $doctrine->getRepository('OpenCephalonBundle:Item');
        $itemIdRSSRepo = $doctrine->getRepository('OpenCephalonBundle:ItemIdRSS');
        $itemFromSourceStreamRepo = $doctrine->getRepository('OpenCephalonBundle:ItemFromSourceStream');

        // Look for Item!
        $item = null;
        if ($modelItem instanceof ItemRSS) {

            $itemId = $itemIdRSSRepo->findOneBy(array('guid'=>$modelItem->getGuid(),'source'=>$sourceStream->getSource()));
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
            if ($modelItem instanceof ItemRSS) {
                $itemId = new ItemIdRSS();
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
            // If not, add it!
            $itemFromSourceStream = $itemFromSourceStreamRepo->findOneBy(array('item'=>$item, 'sourceStream'=>$sourceStream));
            if (!$itemFromSourceStream) {
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
