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
class ProjectController extends Controller
{

    protected $project;


    protected function build($projectId) {
        $doctrine = $this->getDoctrine()->getManager();
        // load
        $repository = $doctrine->getRepository('OpenCephalonBundle:Project');
        $this->project = $repository->findOneByPublicId($projectId);
        if (!$this->project) {
            throw new  NotFoundHttpException('Not found');
        }
        //$this->denyAccessUnlessGranted(ProjectVoter::VIEW, $this->project);
    }


    public function indexAction($projectId)
    {
        // build
        $this->build($projectId);
        //data


        return $this->render('OpenCephalonBundle:Project:index.html.twig', array(
            'project'=>$this->project,
        ));
    }

    public function sourcesAction($projectId)
    {
        // build
        $this->build($projectId);
        //data

        $doctrine = $this->getDoctrine()->getManager();
        $repo = $doctrine->getRepository('OpenCephalonBundle:Source');
        $sources = $repo->findByProject($this->project);

        return $this->render('OpenCephalonBundle:Project:sources.html.twig', array(
            'project'=>$this->project,
            'sources' => $sources,
        ));
    }

    public function outstreamsAction($projectId)
    {
        // build
        $this->build($projectId);
        //data

        $doctrine = $this->getDoctrine()->getManager();
        $repo = $doctrine->getRepository('OpenCephalonBundle:OutStream');
        $outstreams = $repo->findByProject($this->project);

        return $this->render('OpenCephalonBundle:Project:outstreams.html.twig', array(
            'project'=>$this->project,
            'outstreams' => $outstreams,
        ));
    }


    public function newSourceAction($projectId)
    {
        // build
        $this->build($projectId);
        //data


        $doctrine = $this->getDoctrine()->getManager();


        $form = $this->createForm(new SourceNewType());
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {


                $source = new Source();
                $source->setProject($this->project);
                $source->setTitle($form->get('title')->getData());

                $sourceStream = new SourceStream();
                $sourceStream->setSource($source);
                $sourceStream->setURL($form->get('url')->getData());

                $doctrine->persist($source);
                $doctrine->persist($sourceStream);
                $doctrine->flush();
                return $this->redirect($this->generateUrl('opencephalon_project', array('projectId'=>$this->project->getPublicId())));
            }
        }

        return $this->render('OpenCephalonBundle:Project:newSource.html.twig', array(
            'project'=>$this->project,
            'form' => $form->createView(),
        ));
    }

    public function newOutStreamAction($projectId)
    {
        // build
        $this->build($projectId);
        //data


        $doctrine = $this->getDoctrine()->getManager();

        $outStream = new OutStream();
        $outStream->setProject($this->project);

        $form = $this->createForm(new OutStreamNewType(), $outStream);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $doctrine->persist($outStream);
                $doctrine->flush();
                return $this->redirect($this->generateUrl('opencephalon_project', array('projectId'=>$this->project->getPublicId())));
            }
        }

        return $this->render('OpenCephalonBundle:Project:newOutStream.html.twig', array(
            'project'=>$this->project,
            'form' => $form->createView(),
        ));
    }

}
