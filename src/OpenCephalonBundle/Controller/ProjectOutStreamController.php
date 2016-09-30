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


/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
class ProjectOutStreamController extends Controller
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


    public function indexAction($projectId, $outStreamId)
    {
        // build
        $this->build($projectId, $outStreamId);
        //data


        return $this->render('OpenCephalonBundle:ProjectOutStream:index.html.twig', array(
            'project'=>$this->project,
            'outStream' => $this->outStream,
        ));
    }

    public function itemsAction($projectId, $outStreamId)
    {
        // build
        $this->build($projectId, $outStreamId);
        //data

        $doctrine = $this->getDoctrine()->getManager();
        $repo = $doctrine->getRepository('OpenCephalonBundle:Item');
        $items = $repo->getLatestInOutStream($this->outStream, 50);

        return $this->render('OpenCephalonBundle:ProjectOutStream:items.html.twig', array(
            'project'=>$this->project,
            'outStream' => $this->outStream,
            'items' => $items,
        ));
    }



}
