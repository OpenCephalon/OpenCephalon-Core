<?php

namespace OpenCephalonBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use OpenCephalonBundle\Entity\Item;
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


    public function findOneByItem(Item $item) {

        // Try ItemFromSourceStream
        $ifss =  $this->getEntityManager()
                   ->createQuery(
                       ' SELECT ifss FROM OpenCephalonBundle:ItemFromSourceStream ifss'.
                       ' WHERE ifss.item = :item '
                   )
                   ->setParameter('item', $item)
                   ->getResult();

        if ($ifss) {
            return $ifss[0]->getSourceStream()->getSource();
        }

        // Try ItemFromSource
        $ifss =  $this->getEntityManager()
                      ->createQuery(
                          ' SELECT ifs FROM OpenCephalonBundle:ItemFromSource ifs'.
                          ' WHERE ifs.item = :item '
                      )
                      ->setParameter('item', $item)
                      ->getResult();

        if ($ifss) {
            return $ifss[0]->getSource();
        }


    }

}

