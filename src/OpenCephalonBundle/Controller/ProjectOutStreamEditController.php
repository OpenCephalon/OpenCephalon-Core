<?php

namespace OpenCephalonBundle\Controller;

use OpenCephalonBundle\Entity\OutStream;
use OpenCephalonBundle\Entity\Project;
use OpenCephalonBundle\Entity\Source;
use OpenCephalonBundle\Entity\SourceStream;
use OpenCephalonBundle\Entity\OutStreamToTwitter;
use OpenCephalonBundle\Form\Type\OutStreamNewType;
use OpenCephalonBundle\Form\Type\ProjectNewType;
use OpenCephalonBundle\Form\Type\SourceNewType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Abraham\TwitterOAuth\TwitterOAuth;


/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
class ProjectOutStreamEditController extends ProjectOutStreamController
{

    protected function build($projectId, $outStreamId) {
        parent::build($projectId, $outStreamId);
    }

    public function newTwitterAction($projectId, $outStreamId, Request $request)
    {
        // build
        $this->build($projectId, $outStreamId);
        //data

        $twitterKey = $this->container->hasParameter('twitter_key') ? $this->container->getParameter('twitter_key') : null;
        $twitterKeySecret = $this->container->hasParameter('twitter_key_secret') ? $this->container->getParameter('twitter_key_secret') : null;

        if (!$twitterKey || !$twitterKeySecret) {
            return $this->render('OpenCephalonBundle:ProjectOutStreamEdit:newTwitter.noTwitter.html.twig', array(
                'project'=>$this->project,
                'outStream' => $this->outStream,
            ));
        }

        $connection = new TwitterOAuth($twitterKey, $twitterKeySecret);

        $callbackURL = $request->getSchemeAndHttpHost() . $this->generateUrl('opencephalon_project_outstream_new_twitter_callback', array('projectId'=>$this->project->getPublicId(), 'outStreamId'=>$this->outStream->getPublicId()));

        $request_token = $connection->oauth('oauth/request_token', array(
            'oauth_callback' => $callbackURL,
        ));

        $request->getSession()->set( $this->getSessionOAuthTokenKey(), $request_token['oauth_token']);
        $request->getSession()->set( $this->getSessionOAuthTokenSecretKey(), $request_token['oauth_token_secret']);

        $url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));

        return $this->redirect($url);

    }

    public function newTwitterCallbackAction($projectId, $outStreamId, Request $request) {

        // build
        $this->build($projectId, $outStreamId);
        //data

        $twitterKey = $this->container->hasParameter('twitter_key') ? $this->container->getParameter('twitter_key') : null;
        $twitterKeySecret = $this->container->hasParameter('twitter_key_secret') ? $this->container->getParameter('twitter_key_secret') : null;

        if (!$twitterKey || !$twitterKeySecret) {
            return $this->render('OpenCephalonBundle:ProjectOutStreamEdit:newTwitter.noTwitter.html.twig', array(
                'project'=>$this->project,
                'outStream' => $this->outStream,
            ));
        }


        $connection = new TwitterOAuth($twitterKey, $twitterKeySecret, $request->getSession()->get($this->getSessionOAuthTokenKey()), $request->getSession()->get($this->getSessionOAuthTokenSecretKey()));

        $access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $_REQUEST['oauth_verifier']]);


        $outStreamToTwitter = new OutStreamToTwitter();
        $outStreamToTwitter->setOutStream($this->outStream);
        $outStreamToTwitter->setTwitterId($access_token['user_id']);
        $outStreamToTwitter->setTwitterUsername($access_token['screen_name']);
        $outStreamToTwitter->setAccessToken($access_token['oauth_token']);
        $outStreamToTwitter->setAccessTokenSecret($access_token['oauth_token_secret']);
        $outStreamToTwitter->setMinsAfterTweetBeforeNextTweet(50);
        $outStreamToTwitter->setIsActive(false);
        $outStreamToTwitter->setMonPostAfter(7);
        $outStreamToTwitter->setMonPostBefore(22);
        $outStreamToTwitter->setTuePostAfter(7);
        $outStreamToTwitter->setTuePostBefore(22);
        $outStreamToTwitter->setWedPostAfter(7);
        $outStreamToTwitter->setWedPostBefore(22);
        $outStreamToTwitter->setThuPostAfter(7);
        $outStreamToTwitter->setThuPostBefore(22);
        $outStreamToTwitter->setFriPostAfter(7);
        $outStreamToTwitter->setFriPostBefore(22);
        $outStreamToTwitter->setSatPostAfter(7);
        $outStreamToTwitter->setSatPostBefore(22);
        $outStreamToTwitter->setSunPostAfter(7);
        $outStreamToTwitter->setSunPostBefore(22);
        $outStreamToTwitter->setContentPrefix('');

        $doctrine = $this->getDoctrine()->getManager();

        $doctrine->persist($outStreamToTwitter);
        $doctrine->flush();

        return $this->redirect($this->generateUrl('opencephalon_project_outstream', array(
            'projectId' => $this->project->getPublicId(),
            'outStreamId' => $this->outStream->getPublicId(),
        )));

    }


    protected function getSessionOAuthTokenKey() {
        return 'OutStreamToTwitterProject'.$this->project->getId().'OutStream'.$this->outStream->getId().'Token';
    }

    protected function getSessionOAuthTokenSecretKey() {
        return 'OutStreamToTwitterProject'.$this->project->getId().'OutStream'.$this->outStream->getId().'Secret';
    }

}
