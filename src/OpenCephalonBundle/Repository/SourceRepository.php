<?php

namespace OpenCephalonBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use OpenCephalonBundle\Entity\Project;



/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
class SourceRepository extends EntityRepository
{



    public function doesPublicIdExist($id, Project $project)
    {
        if ($project->getId()) {
            $s =  $this->getEntityManager()
                ->createQuery(
                    ' SELECT cs FROM OpenCephalonBundle:Source cs'.
                    ' WHERE cs.project = :project AND cs.publicId = :public_id'
                )
                ->setParameter('project', $project)
                ->setParameter('public_id', $id)
                ->getResult();
            return (boolean)$s;
        } else {
            return false;
        }
    }

}