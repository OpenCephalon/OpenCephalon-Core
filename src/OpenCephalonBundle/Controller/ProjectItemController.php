<?php

namespace OpenCephalonBundle\Controller;

use OpenCephalonBundle\Entity\Item;
use OpenCephalonBundle\Entity\OutStream;
use OpenCephalonBundle\Entity\Project;
use OpenCephalonBundle\Entity\Source;
use OpenCephalonBundle\Entity\SourceStream;
use OpenCephalonBundle\Form\Type\OutStreamNewType;
use OpenCephalonBundle\Form\Type\ProjectNewType;
use OpenCephalonBundle\Form\Type\SourceNewType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
class ProjectItemController extends Controller
{
    /** @var  Project */
    protected $project;

    /** @var Item */
    protected $item;

    protected function build($projectId, $itemId) {
        $doctrine = $this->getDoctrine()->getManager();
        // load
        $repository = $doctrine->getRepository('OpenCephalonBundle:Project');
        $this->project = $repository->findOneByPublicId($projectId);
        if (!$this->project) {
            throw new  NotFoundHttpException('Not found');
        }
        //$this->denyAccessUnlessGranted(ProjectVoter::VIEW, $this->project);
        // load
        $repository = $doctrine->getRepository('OpenCephalonBundle:Item');
        $this->item = $repository->findOneBy(array('project'=>$this->project, 'publicId'=>$itemId));
        if (!$this->item) {
            throw new  NotFoundHttpException('Not found');
        }
    }


    public function indexAction($projectId, $itemId, Request $request)
    {
        $doctrine = $this->getDoctrine()->getManager();
        $itemRepo = $doctrine->getRepository('OpenCephalonBundle:Item');
        $outStreamRepo = $doctrine->getRepository('OpenCephalonBundle:OutStream');

        // build
        $this->build($projectId, $itemId);

        // action
        if ($request->request->get('outStream')) {
            $outStream = $outStreamRepo->findOneBy(array('publicId'=>$request->request->get('outStream'), 'project'=>$this->project));
            if ($outStream) {
               if ($request->request->get('action') == 'remove') {
                   $itemRepo->removeItemFromOutStream($this->item, $outStream, $this->getUser());
                }
            }
        }

        //data
        $sourceStreams = $doctrine->getRepository('OpenCephalonBundle:SourceStream')->findByItem($this->item);

        $outstreams = array();
        foreach($doctrine->getRepository('OpenCephalonBundle:OutStream')->findByProject($this->project) as $outstream) {
            $outstreams[] = array(
                'outStream' => $outstream,
                'inOutStream' => $itemRepo->isItemInOutStream($this->item, $outstream),
            );
        }


        return $this->render('OpenCephalonBundle:ProjectItem:index.html.twig', array(
            'project'=>$this->project,
            'item' => $this->item,
            'sourceStreams' => $sourceStreams,
            'outStreams' => $outstreams,
        ));
    }

}
