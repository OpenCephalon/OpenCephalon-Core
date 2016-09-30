<?php

namespace OpenCephalonBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use OpenCephalonBundle\Entity\OutStream;
use OpenCephalonBundle\Entity\Project;
use OpenCephalonBundle\Entity\Source;



/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
class ItemRepository extends EntityRepository
{



    public function doesPublicIdExist($id, Project $project)
    {
        if ($project->getId()) {
            $s =  $this->getEntityManager()
                ->createQuery(
                    ' SELECT i FROM OpenCephalonBundle:item i'.
                    ' WHERE i.project = :project AND i.publicId = :public_id'
                )
                ->setParameter('project', $project)
                ->setParameter('public_id', $id)
                ->getResult();
            return (boolean)$s;
        } else {
            return false;
        }
    }

    public function getLatestInOutStream(OutStream $outStream, $count=50) {
        return $this->getEntityManager()
            ->createQuery(
                ' SELECT i FROM OpenCephalonBundle:item i'.
                ' JOIN i.outStreamHasItems oshi '.
                ' WHERE oshi.outStream = :outstream '.
                ' ORDER BY i.publishedAt DESC '
            )
            ->setMaxResults($count)
            ->setParameter('outstream', $outStream)
            ->getResult();
    }

}