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


    public function indexAction($projectId, $itemId)
    {
        // build
        $this->build($projectId, $itemId);
        //data

        return $this->render('OpenCephalonBundle:ProjectItem:index.html.twig', array(
            'project'=>$this->project,
            'item' => $this->item,
        ));
    }

}
