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
class ProjectEditController extends ProjectController
{


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

                return $this->redirect($this->generateUrl('opencephalon_project_source_stream', array(
                    'projectId'=>$this->project->getPublicId(),
                    'sourceId'=>$source->getPublicId(),
                    'streamId'=>$sourceStream->getPublicId(),
                )));
            }
        }

        return $this->render('OpenCephalonBundle:ProjectEdit:newSource.html.twig', array(
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
                return $this->redirect($this->generateUrl('opencephalon_project_outstream', array(
                    'projectId'=>$this->project->getPublicId(),
                    'outStreamId'=>$outStream->getPublicId(),
                )));
            }
        }

        return $this->render('OpenCephalonBundle:ProjectEdit:newOutStream.html.twig', array(
            'project'=>$this->project,
            'form' => $form->createView(),
        ));
    }

}
