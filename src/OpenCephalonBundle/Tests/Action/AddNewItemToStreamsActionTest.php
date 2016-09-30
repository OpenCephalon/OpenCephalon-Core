<?php

namespace OpenCephalonBundle\Tests\Action;

use OpenCephalonBundle\Action\AddNewItemToStreamsAction;
use OpenCephalonBundle\Entity\Item;
use OpenCephalonBundle\Entity\OutStream;
use OpenCephalonBundle\Entity\Project;
use OpenCephalonBundle\Entity\Source;
use OpenCephalonBundle\Entity\SourceStream;
use OpenCephalonBundle\Entity\SourceStreamToOutStream;
use OpenCephalonBundle\Entity\User;
use OpenCephalonBundle\Tests\BaseTestWithDataBase;


/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
class AddNewItemToStreamsActionTest extends BaseTestWithDataBase {


    function test1() {

        $user = new User();
        $user->setUsername('test1');
        $user->setEmail('test1@example.org');
        $user->setPassword('1234');
        $this->em->persist($user);

        $project = new Project();
        $project->setTitle('Test');
        $project->setPublicId('test');
        $project->setOwner($user);
        $this->em->persist($project);

        $this->em->flush();

        $source = new Source();
        $source->setProject($project);
        $source->setTitle('Test');
        $this->em->persist($source);

        $sourceStream = new SourceStream();
        $sourceStream->setSource($source);
        $sourceStream->setUrl('http://example.com/');
        $this->em->persist($sourceStream);

        $outStream = new OutStream();
        $outStream->setProject($project);
        $outStream->setPublicId('out');
        $outStream->setTitle('Out');
        $this->em->persist($outStream);

        $this->em->flush();

        $sourceStreamToOutStream = new SourceStreamToOutStream();
        $sourceStreamToOutStream->setSourceStream($sourceStream);
        $sourceStreamToOutStream->setOutStream($outStream);
        $this->em->persist($sourceStreamToOutStream);

        $item = new Item();
        $item->setProject($project);
        $item->setSourceStream($sourceStream);
        $item->setPublishedAt(new \DateTime());
        $this->em->persist($item);

        $this->em->flush();

        // TEST

        $action = new AddNewItemToStreamsAction($this->container);
        $action->go($item);

        $repo = $this->em->getRepository('OpenCephalonBundle:OutStreamHasItem');
        $links = $repo->findAll();

        $this->assertEquals(1, count($links));

        $link = $links[0];

        $this->assertEquals($outStream->getId(), $link->getOutStream()->getId());
        $this->assertEquals($item->getId(), $link->getItem()->getId());

    }

}