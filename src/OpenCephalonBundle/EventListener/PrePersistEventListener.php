<?php

namespace OpenCephalonBundle\EventListener;



use Doctrine\ORM\Event\LifecycleEventArgs;
use OpenCephalonBundle\Entity\Item;
use OpenCephalonBundle\Entity\Source;
use OpenCephalonBundle\Entity\SourceStream;
use OpenCephalonBundle\Entity\SourceStreamToOutStreamCondition;
use OpenCephalonBundle\OpenCephalonBundle;




/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
class PrePersistEventListener  {


    const MIN_LENGTH = 5;
    const MAX_LENGTH = 250;
    const LENGTH_STEP = 1;

    function PrePersist(LifecycleEventArgs $args) {
        $entity = $args->getEntity();

        if ($entity instanceof Source) {
            if (!$entity->getPublicId()) {
                $manager = $args->getEntityManager()->getRepository('OpenCephalonBundle\Entity\Source');
                $idLen = self::MIN_LENGTH;
                $id = OpenCephalonBundle::createKey(1, $idLen);
                while ($manager->doesPublicIdExist($id, $entity->getProject())) {
                    if ($idLen < self::MAX_LENGTH) {
                        $idLen = $idLen + self::LENGTH_STEP;
                    }
                    $id = OpenCephalonBundle::createKey(1, $idLen);
                }
                $entity->setPublicId($id);
            }
        } else if ($entity instanceof SourceStream) {
            if (!$entity->getPublicId()) {
                $manager = $args->getEntityManager()->getRepository('OpenCephalonBundle\Entity\SourceStream');
                $idLen = self::MIN_LENGTH;
                $id =  OpenCephalonBundle::createKey(1,$idLen);
                while($manager->doesPublicIdExist($id, $entity->getSource())) {
                    if ($idLen < self::MAX_LENGTH) {
                        $idLen = $idLen + self::LENGTH_STEP;
                    }
                    $id =  OpenCephalonBundle::createKey(1,$idLen);
                }
                $entity->setPublicId($id);
            }
        } else if ($entity instanceof Item) {
            if (!$entity->getPublicId()) {
                $manager = $args->getEntityManager()->getRepository('OpenCephalonBundle\Entity\Item');
                $idLen = self::MIN_LENGTH;
                $id =  OpenCephalonBundle::createKey(1,$idLen);
                while($manager->doesPublicIdExist($id, $entity->getProject())) {
                    if ($idLen < self::MAX_LENGTH) {
                        $idLen = $idLen + self::LENGTH_STEP;
                    }
                    $id =  OpenCephalonBundle::createKey(1,$idLen);
                }
                $entity->setPublicId($id);
            }
        } else if ($entity instanceof SourceStreamToOutStreamCondition) {
            if (!$entity->getPublicId()) {
                $manager = $args->getEntityManager()->getRepository('OpenCephalonBundle\Entity\SourceStreamToOutStreamCondition');
                $idLen = self::MIN_LENGTH;
                $id =  OpenCephalonBundle::createKey(1,$idLen);
                while($manager->doesPublicIdExist($id, $entity->getSourceStream(), $entity->getOutStream())) {
                    if ($idLen < self::MAX_LENGTH) {
                        $idLen = $idLen + self::LENGTH_STEP;
                    }
                    $id =  OpenCephalonBundle::createKey(1,$idLen);
                }
                $entity->setPublicId($id);
            }
        }

    }

}

