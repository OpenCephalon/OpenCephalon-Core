<?php

namespace OpenCephalonBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use OpenCephalonBundle\Entity\Item;
use OpenCephalonBundle\Entity\OutStream;
use OpenCephalonBundle\Entity\OutStreamHasItem;
use OpenCephalonBundle\Entity\Project;
use OpenCephalonBundle\Entity\Source;
use OpenCephalonBundle\Entity\SourceStream;
use OpenCephalonBundle\Entity\User;


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

    public function getLatestInSourceStream(SourceStream $sourceStream, $count=50) {
        return $this->getEntityManager()
            ->createQuery(
                ' SELECT i FROM OpenCephalonBundle:item i'.
                ' JOIN i.itemFromSourceStreams ifss '.
                ' WHERE ifss.sourceStream = :sourcestream '.
                ' ORDER BY i.effectivePublishedAt DESC '
            )
            ->setMaxResults($count)
            ->setParameter('sourcestream', $sourceStream)
            ->getResult();
    }

    public function getLatestInOutStream(OutStream $outStream, $count=50) {
        return $this->getEntityManager()
            ->createQuery(
                ' SELECT i FROM OpenCephalonBundle:item i'.
                ' JOIN i.outStreamHasItems oshi '.
                ' WHERE oshi.outStream = :outstream AND oshi.removedAt IS NULL '.
                ' ORDER BY i.effectivePublishedAt DESC '
            )
            ->setMaxResults($count)
            ->setParameter('outstream', $outStream)
            ->getResult();
    }


    public function getInOutStreamFromEffectivePublished(OutStream $outStream, \DateTime $after) {
        return $this->getEntityManager()
            ->createQuery(
                ' SELECT i FROM OpenCephalonBundle:item i'.
                ' JOIN i.outStreamHasItems oshi '.
                ' WHERE oshi.outStream = :outstream AND oshi.removedAt IS NULL AND i.effectivePublishedAt > :after '.
                ' ORDER BY i.effectivePublishedAt ASC '
            )
            ->setParameter('outstream', $outStream)
            ->setParameter('after', $after)
            ->getResult();
    }

    public function wasItemEverInOutStream(Item $item, OutStream $outStream) {
        $s =  $this->getEntityManager()
            ->createQuery(
                ' SELECT oshi FROM OpenCephalonBundle:OutStreamHasItem oshi'.
                ' WHERE oshi.item = :item AND oshi.outStream = :outStream '
            )
            ->setParameter('item', $item)
            ->setParameter('outStream', $outStream)
            ->getResult();
        return (boolean)$s;
    }

    public function isItemInOutStream(Item $item, OutStream $outStream) {
        $s =  $this->getEntityManager()
            ->createQuery(
                ' SELECT oshi FROM OpenCephalonBundle:OutStreamHasItem oshi'.
                ' WHERE oshi.item = :item AND oshi.outStream = :outStream AND oshi.removedAt IS NULL'
            )
            ->setParameter('item', $item)
            ->setParameter('outStream', $outStream)
            ->getResult();
        return (boolean)$s;
    }

    public function removeItemFromOutStream(Item $item, OutStream $outStream, User $user = null) {

        foreach($this->getEntityManager()->getRepository('OpenCephalonBundle:OutStreamHasItem')->findBy(array('item'=>$item, 'outStream'=>$outStream)) as $outStreamHasItem) {
            if (!$outStreamHasItem->getRemovedAt()) {
                $outStreamHasItem->setRemovedAt(new \DateTime());
                $outStreamHasItem->setRemovedByUser($user);
                $this->getEntityManager()->persist($outStreamHasItem);
                $this->getEntityManager()->flush($outStreamHasItem);
            }
        }

    }
    public function addItemToOutStream(Item $item, OutStream $outStream, User $user = null) {

        if (!$this->isItemInOutStream($item, $outStream)) {

            $outStreamHasItem = new OutStreamHasItem();
            $outStreamHasItem->setItem($item);
            $outStreamHasItem->setOutStream($outStream);
            $outStreamHasItem->setAddedByUser($user);

            $this->getEntityManager()->persist($outStreamHasItem);
            $this->getEntityManager()->flush($outStreamHasItem);

        }

    }

}
