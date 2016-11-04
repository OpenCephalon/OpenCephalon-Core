<?php

namespace OpenCephalonBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use OpenCephalonBundle\Entity\Item;
use OpenCephalonBundle\Entity\OutStream;
use OpenCephalonBundle\Entity\Project;
use OpenCephalonBundle\Entity\SourceStream;


/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
class SourceStreamToOutStreamConditionRepository extends EntityRepository
{



    public function doesPublicIdExist($id, SourceStream $sourceStream, OutStream $outStream)
    {
        if ($sourceStream->getId() && $outStream->getId()) {
            $s =  $this->getEntityManager()
                ->createQuery(
                    ' SELECT sstosc FROM OpenCephalonBundle:SourceStreamToOutStreamCondition sstosc'.
                    ' WHERE sstosc.sourceStream = :sourceStream AND  sstosc.outStream = :outStream AND sstosc.publicId = :public_id'
                )
                ->setParameter('sourceStream', $sourceStream)
                ->setParameter('outStream', $outStream)
                ->setParameter('public_id', $id)
                ->getResult();
            return (boolean)$s;
        } else {
            return false;
        }
    }

}

