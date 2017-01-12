<?php


namespace OpenCephalonBundle\Action;

use OpenCephalonBundle\Entity\Item;
use OpenCephalonBundle\Entity\OutStreamToTwitter;
use OpenCephalonBundle\Entity\OutStreamToTwitterHasItem;
use Abraham\TwitterOAuth\TwitterOAuth;

/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
class OutStreamTweetAction {

    protected $container;

    function __construct( $container ) {
        $this->container = $container;
    }

    function go(OutStreamToTwitter $outStreamToTwitter) {

        if (!$outStreamToTwitter->getIsActive()) {
            return false;
        }

        // TODO CHECK TIMES OF DAY - ARE WE ALLOWED TO POST NOW?

        $doctrine = $this->container->get('doctrine')->getManager();

        $itemRepository = $doctrine->getRepository('OpenCephalonBundle:Item');
        $outStreamToTwitterHasItemRepository = $doctrine->getRepository('OpenCephalonBundle:OutStreamToTwitterHasItem');

        $after = new \DateTime();
        $after->sub(new \DateInterval('P3D'));

        $items  = $itemRepository->getInOutStreamFromEffectivePublished($outStreamToTwitter->getOutStream(), $after);


        $twitterKey = $this->container->hasParameter('twitter_key') ? $this->container->getParameter('twitter_key') : null;
        $twitterKeySecret = $this->container->hasParameter('twitter_key_secret') ? $this->container->getParameter('twitter_key_secret') : null;

        $connection = new TwitterOAuth($twitterKey, $twitterKeySecret, $outStreamToTwitter->getAccessToken(), $outStreamToTwitter->getAccessTokenSecret());

        foreach($items as $item) {

            $outStreamToTwitterHasItem = $outStreamToTwitterHasItemRepository->findBy(array('outStreamToTwitter'=>$outStreamToTwitter, 'item'=>$item));
            if (!$outStreamToTwitterHasItem) {

                $outStreamToTwitterHasItem = new OutStreamToTwitterHasItem();
                $outStreamToTwitterHasItem->setOutStreamToTwitter($outStreamToTwitter);
                $outStreamToTwitterHasItem->setItem($item);
                $doctrine->persist($outStreamToTwitterHasItem);
                $doctrine->flush($outStreamToTwitterHasItem);

                $statues = $connection->post("statuses/update", ["status" => $this->getTweetContents($outStreamToTwitter, $item)]);

                if (property_exists($statues, 'error') && $statues->error) {
                    var_dump($statues->error);
                } else {
                    $outStreamToTwitterHasItem->setTweetId( $statues->id_str );
                    $outStreamToTwitterHasItem->setTweetedAt( new \DateTime() );
                    $doctrine->persist( $outStreamToTwitterHasItem );
                    $doctrine->flush( $outStreamToTwitterHasItem );
                }
                // At moment only Tweet one at a time!
                return;
            }
        }




    }

    protected function getTweetContents(OutStreamToTwitter $outStreamToTwitter, Item $item) {

        $out = ($outStreamToTwitter->hasContentPrefix() ? $outStreamToTwitter->getContentPrefix() . ' ': '').
               $item->getTitle();

        $shortenedLinksLength = 30;

        if (strlen($out) < (140 - $shortenedLinksLength)) {
            return $out . ' '. $item->getUrl();
        } else {
            while(substr($out, -1) != ' ' || strlen($out) > (140 - $shortenedLinksLength - 3)) {
                $out = substr($out, 0, -1);
            }
            return $out . '... '. $item->getUrl();
        }

    }

}

