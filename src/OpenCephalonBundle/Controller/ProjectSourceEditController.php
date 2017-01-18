<?php

namespace OpenCephalonBundle\Controller;

use OpenCephalonBundle\Entity\Item;
use OpenCephalonBundle\Entity\ItemFromSource;
use OpenCephalonBundle\Entity\SourceStream;
use OpenCephalonBundle\Form\Type\ItemNewType;
use OpenCephalonBundle\Form\Type\SourceStreamNewType;


/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
class ProjectSourceEditController extends ProjectSourceController
{


    protected function build($projectId, $sourceId) {
        parent::build($projectId, $sourceId);
        //$this->denyAccessUnlessGranted(ProjectVoter::VIEW, $this->project);
    }


    public function newStreamAction($projectId, $sourceId)
    {
        // build
        $this->build($projectId, $sourceId);
        //data

        $doctrine = $this->getDoctrine()->getManager();


        $form = $this->createForm(new SourceStreamNewType());
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {


                $sourceStream = new SourceStream();
                $sourceStream->setSource($this->source);
                $sourceStream->setURL($form->get('url')->getData());
                $sourceStream->setIsActive(true);

                $doctrine->persist($sourceStream);
                $doctrine->flush();
                return $this->redirect($this->generateUrl('opencephalon_project_source_stream', array(
                    'projectId'=>$this->project->getPublicId(),
                    'sourceId'=>$this->source->getPublicId(),
                    'streamId'=>$sourceStream->getPublicId(),
                )));
            }
        }

        return $this->render('OpenCephalonBundle:ProjectSourceEdit:newStream.html.twig', array(
            'project' => $this->project,
            'source' => $this->source,
            'form' => $form->createView(),
        ));
    }


    public function newItemAction($projectId, $sourceId)
    {
        // build
        $this->build($projectId, $sourceId);
        //data

        $doctrine = $this->getDoctrine()->getManager();

        $item = new Item();
        $item->setProject($this->project);
        $now = new \DateTime();
        $item->setPublishedAt($now);
        $item->setEffectivePublishedAt($now);

        $form = $this->createForm(new ItemNewType(), $item);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $doctrine->persist($item);

                $itemFromSource = new ItemFromSource();
                $itemFromSource->setItem($item);
                $itemFromSource->setSource($this->source);
                $doctrine->persist($itemFromSource);

                $doctrine->flush();
                return $this->redirect($this->generateUrl('opencephalon_project_item', array(
                    'projectId'=>$this->project->getPublicId(),
                    'itemId'=>$item->getPublicId(),
                )));
            }
        }

        return $this->render('OpenCephalonBundle:ProjectSourceEdit:newItem.html.twig', array(
            'project' => $this->project,
            'source' => $this->source,
            'form' => $form->createView(),
        ));
    }



}
