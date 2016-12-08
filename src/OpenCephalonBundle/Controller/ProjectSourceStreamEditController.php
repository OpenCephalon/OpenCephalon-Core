<?php

namespace OpenCephalonBundle\Controller;


use OpenCephalonBundle\Form\Type\SourceStreamEditType;
use Symfony\Component\HttpFoundation\Request;


/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
class ProjectSourceStreamEditController extends ProjectSourceStreamController
{


    protected function build($projectId, $sourceId, $streamId) {
        parent::build($projectId, $sourceId, $streamId);
        //$this->denyAccessUnlessGranted(ProjectVoter::EDIT, $this->project);
    }


    public function editAction($projectId, $sourceId, $streamId)
    {
        // build
        $this->build($projectId, $sourceId, $streamId);
        //data

        $doctrine = $this->getDoctrine()->getManager();

        $form = $this->createForm(new SourceStreamEditType(), $this->sourceStream);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $doctrine->persist($this->sourceStream);
                $doctrine->flush();

                return $this->redirect($this->generateUrl('opencephalon_project_source_stream', array(
                    'projectId'=>$this->project->getPublicId(),
                    'sourceId'=>$this->source->getPublicId(),
                    'streamId'=>$this->sourceStream->getPublicId(),
                )));
            }
        }


        return $this->render('OpenCephalonBundle:ProjectSourceStreamEdit:edit.html.twig', array(
            'project' => $this->project,
            'source' => $this->source,
            'sourceStream' => $this->sourceStream,
            'form' => $form->createView(),
        ));
    }





}
