<?php

namespace OpenCephalonBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use OpenCephalonBundle\Entity\Item;
use OpenCephalonBundle\Entity\OutStream;
use OpenCephalonBundle\Entity\Project;
use OpenCephalonBundle\Entity\Source;
use OpenCephalonBundle\Entity\SourceStream;
use OpenCephalonBundle\Entity\User;


/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
class OutStreamToTwitterRepository extends EntityRepository
{



    public function doesPublicIdExist($id, OutStream $outStream)
    {
        if ($outStream->getId()) {
            $s =  $this->getEntityManager()
                ->createQuery(
                    ' SELECT i FROM OpenCephalonBundle:OutStreamToTwitter i'.
                    ' WHERE i.outStream = :outStream AND i.publicId = :public_id'
                )
                ->setParameter('outStream', $outStream)
                ->setParameter('public_id', $id)
                ->getResult();
            return (boolean)$s;
        } else {
            return false;
        }
    }



}
