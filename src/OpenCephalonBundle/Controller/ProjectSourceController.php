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
class ProjectSourceController extends Controller
{

    protected $project;

    protected $source;

    protected function build($projectId, $sourceId) {
        $doctrine = $this->getDoctrine()->getManager();
        // load
        $repository = $doctrine->getRepository('OpenCephalonBundle:Project');
        $this->project = $repository->findOneByPublicId($projectId);
        if (!$this->project) {
            throw new  NotFoundHttpException('Not found');
        }
        //$this->denyAccessUnlessGranted(ProjectVoter::VIEW, $this->project);
        // load
        $repository = $doctrine->getRepository('OpenCephalonBundle:Source');
        $this->source = $repository->findOneBy(array('project'=>$this->project, 'publicId'=>$sourceId));
        if (!$this->source) {
            throw new  NotFoundHttpException('Not found');
        }
        //$this->denyAccessUnlessGranted(ProjectVoter::VIEW, $this->project);
    }


    public function indexAction($projectId, $sourceId)
    {
        // build
        $this->build($projectId, $sourceId);
        //data


        return $this->render('OpenCephalonBundle:ProjectSource:index.html.twig', array(
            'project' => $this->project,
            'source' => $this->source,
        ));
    }


    public function streamsAction($projectId, $sourceId)
    {
        // build
        $this->build($projectId, $sourceId);
        //data

        $doctrine = $this->getDoctrine()->getManager();
        $repo = $doctrine->getRepository('OpenCephalonBundle:SourceStream');
        $streams = $repo->findBySource($this->source);


        return $this->render('OpenCephalonBundle:ProjectSource:streams.html.twig', array(
            'project' => $this->project,
            'source' => $this->source,
            'streams' => $streams,
        ));
    }


}
