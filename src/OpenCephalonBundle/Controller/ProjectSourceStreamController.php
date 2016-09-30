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
class ProjectSourceStreamController extends Controller
{

    protected $project;

    protected $source;

    protected $sourceStream;

    protected function build($projectId, $sourceId, $streamId) {
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
        //$this->denyAccessUnlessGranted(ProjectVoter::VIEW, $this->project);
    }


    public function indexAction($projectId, $sourceId, $streamId)
    {
        // build
        $this->build($projectId, $sourceId, $streamId);
        //data


        return $this->render('OpenCephalonBundle:ProjectSourceStream:index.html.twig', array(
            'project' => $this->project,
            'source' => $this->source,
            'sourceStream' => $this->sourceStream,
        ));
    }


    public function outstreamsAction($projectId, $sourceId, $streamId, Request $request)
    {
        $doctrine = $this->getDoctrine()->getManager();
        $outStreamRepo = $doctrine->getRepository('OpenCephalonBundle:OutStream');
        $sourceStreamToOutStreamRepo = $doctrine->getRepository('OpenCephalonBundle:SourceStreamToOutStream');

        // build
        $this->build($projectId, $sourceId, $streamId);

        // action
        if ($request->request->get('outStream')) {
            $outStream = $outStreamRepo->findOneBy(array('publicId'=>$request->request->get('outStream'), 'project'=>$this->project));
            if ($outStream) {
                if ($request->request->get('action') == 'add') {

                    $sourceStreamToOutStream = new SourceStreamToOutStream();
                    $sourceStreamToOutStream->setOutStream($outStream);
                    $sourceStreamToOutStream->setSourceStream($this->sourceStream);
                    $doctrine->persist($sourceStreamToOutStream);
                    $doctrine->flush($sourceStreamToOutStream);

                } else if ($request->request->get('action') == 'remove') {

                    $sourceStreamToOutStream = $sourceStreamToOutStreamRepo->findOneBy(array('outStream'=>$outStream, 'sourceStream'=>$this->sourceStream));
                    $doctrine->remove($sourceStreamToOutStream);
                    $doctrine->flush($sourceStreamToOutStream);

                }
            }
        }

        //data
        $outstreams = array();
        foreach($outStreamRepo->findByProject($this->project) as $outstream) {
            $outstreams[] = array(
                'outstream' => $outstream,
                'sourceStreamToOutStream' => $sourceStreamToOutStreamRepo->findOneBy(array('outStream'=>$outstream, 'sourceStream'=>$this->sourceStream)),
            );
        }

        // view
        return $this->render('OpenCephalonBundle:ProjectSourceStream:outstreams.html.twig', array(
            'project' => $this->project,
            'source' => $this->source,
            'sourceStream' => $this->sourceStream,
            'outstreams' => $outstreams,
        ));
    }



}
