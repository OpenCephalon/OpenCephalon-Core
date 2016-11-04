<?php

namespace OpenCephalonBundle\Controller;

use OpenCephalonBundle\Entity\OutStream;
use OpenCephalonBundle\Entity\Project;
use OpenCephalonBundle\Entity\Source;
use OpenCephalonBundle\Entity\SourceStream;
use OpenCephalonBundle\Entity\SourceStreamToOutStream;
use OpenCephalonBundle\Form\Type\OutStreamNewType;
use OpenCephalonBundle\Form\Type\ProjectNewType;
use OpenCephalonBundle\Form\Type\SourceNewType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
class ProjectSourceStreamToOutStreamController extends Controller
{

    /** @var  Project */
    protected $project;

    /** @var  Source */
    protected $source;

    /** @var SourceStream */
    protected $sourceStream;

    /** @var OutStream */
    protected $outStream;

    protected function build($projectId, $sourceId, $streamId, $outStreamId) {
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
        // load
        $repository = $doctrine->getRepository('OpenCephalonBundle:SourceStream');
        $this->sourceStream = $repository->findOneBy(array('source'=>$this->source, 'publicId'=>$streamId));
        if (!$this->sourceStream) {
            throw new  NotFoundHttpException('Not found');
        }
        // load
        $repository = $doctrine->getRepository('OpenCephalonBundle:OutStream');
        $this->outStream = $repository->findOneBy(array('project'=>$this->project, 'publicId'=>$outStreamId));
        if (!$this->outStream) {
            throw new  NotFoundHttpException('Not found');
        }
        //$this->denyAccessUnlessGranted(ProjectVoter::VIEW, $this->project);
    }


    public function conditionsAction($projectId, $sourceId, $streamId, $outStreamId)
    {
        // build
        $this->build($projectId, $sourceId, $streamId, $outStreamId);
        //data

        $doctrine = $this->getDoctrine()->getManager();

        $conditions = $doctrine->getRepository('OpenCephalonBundle:SourceStreamToOutStreamCondition')->findBy(array('sourceStream'=>$this->sourceStream,'outStream'=>$this->outStream));

        return $this->render('OpenCephalonBundle:ProjectSourceStreamToOutStream:conditions.html.twig', array(
            'project' => $this->project,
            'source' => $this->source,
            'sourceStream' => $this->sourceStream,
            'outStream' => $this->outStream,
            'conditions' => $conditions,
        ));
    }





}
