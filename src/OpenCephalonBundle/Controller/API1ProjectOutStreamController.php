<?php

namespace OpenCephalonBundle\Controller;

use OpenCephalonBundle\Entity\OutStream;
use OpenCephalonBundle\Entity\Project;
use OpenCephalonBundle\Entity\Source;
use OpenCephalonBundle\Entity\SourceStream;
use OpenCephalonBundle\Form\Type\OutStreamNewType;
use OpenCephalonBundle\Form\Type\ProjectNewType;
use OpenCephalonBundle\Form\Type\SourceNewType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
class API1ProjectOutStreamController extends Controller
{

    protected $project;

    protected $outStream;

    protected function build($projectId, $outStreamId) {
        $doctrine = $this->getDoctrine()->getManager();
        // load
        $repository = $doctrine->getRepository('OpenCephalonBundle:Project');
        $this->project = $repository->findOneByPublicId($projectId);
        if (!$this->project) {
            throw new  NotFoundHttpException('Not found');
        }
        //$this->denyAccessUnlessGranted(ProjectVoter::VIEW, $this->project);
        // load
        $repository = $doctrine->getRepository('OpenCephalonBundle:OutStream');
        $this->outStream = $repository->findOneBy(array('project'=>$this->project, 'publicId'=>$outStreamId));
        if (!$this->outStream) {
            throw new  NotFoundHttpException('Not found');
        }
    }


    public function itemsJSONAction($projectId, $outStreamId)
    {
        // build
        $this->build($projectId, $outStreamId);
        //data

        $doctrine = $this->getDoctrine()->getManager();
        $repo = $doctrine->getRepository('OpenCephalonBundle:Item');

        $data = array(
            'items'=>array(),
        );

        foreach($repo->getLatestInOutStream($this->outStream, 50) as $item) {
            $data['items'][] = array(
                'title'=>$item->getTitle(),
                'description'=>$item->getDescription(),
                'url'=>$item->getURL(),
                'source'=>array(
                    'title'=>$item->getSourceStream()->getSource()->getTitle(),
                ),

            );
        }


        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'text/javascript');
        return $response;

    }



}
