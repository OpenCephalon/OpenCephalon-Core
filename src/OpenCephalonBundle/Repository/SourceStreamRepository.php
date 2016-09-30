<?php

namespace OpenCephalonBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use OpenCephalonBundle\Entity\Source;



/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
class SourceStreamRepository extends EntityRepository
{




    public function doesPublicIdExist($id, Source $source)
    {
        if ($source->getId()) {
            $s =  $this->getEntityManager()
                ->createQuery(
                    ' SELECT cs FROM OpenCephalonBundle:SourceStream cs'.
                    ' WHERE cs.source = :source AND cs.publicId = :public_id'
                )
                ->setParameter('source', $source)
                ->setParameter('public_id', $id)
                ->getResult();
            return (boolean)$s;
        } else {
            return false;
        }
    }


    public function getActive()
    {
        return  $this->getEntityManager()
            ->createQuery(
                ' SELECT ss FROM OpenCephalonBundle:SourceStream ss'
            )
            ->getResult();
    }


}