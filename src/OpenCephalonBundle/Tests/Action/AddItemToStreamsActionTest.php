<?php

namespace OpenCephalonBundle\Tests\Action;

use OpenCephalonBundle\Action\AddItemToStreamsAction;
use OpenCephalonBundle\Entity\Item;
use OpenCephalonBundle\Entity\OutStream;
use OpenCephalonBundle\Entity\Project;
use OpenCephalonBundle\Entity\Source;
use OpenCephalonBundle\Entity\SourceStream;
use OpenCephalonBundle\Entity\SourceStreamToOutStream;
use OpenCephalonBundle\Entity\SourceStreamToOutStreamCondition;
use OpenCephalonBundle\Entity\User;
use OpenCephalonBundle\Tests\BaseTestWithDataBase;


/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
class AddItemToStreamsActionTest extends BaseTestWithDataBase {


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
        $item->setPublishedAt(new \DateTime());
        $item->setEffectivePublishedAt(new \DateTime());
        $this->em->persist($item);

        $this->em->flush();

        // TEST

        $action = new AddItemToStreamsAction($this->container);
        $action->go($sourceStream, $item);

        $repo = $this->em->getRepository('OpenCephalonBundle:OutStreamHasItem');
        $links = $repo->findAll();

        $this->assertEquals(1, count($links));

        $link = $links[0];

        $this->assertEquals($outStream->getId(), $link->getOutStream()->getId());
        $this->assertEquals($item->getId(), $link->getItem()->getId());

    }


    function testIntoTwoOutStreams1() {

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

        $outStream1 = new OutStream();
        $outStream1->setProject($project);
        $outStream1->setPublicId('out');
        $outStream1->setTitle('Out');
        $this->em->persist($outStream1);

        $outStream2 = new OutStream();
        $outStream2->setProject($project);
        $outStream2->setPublicId('out2');
        $outStream2->setTitle('Out2');
        $this->em->persist($outStream2);

        $this->em->flush();

        $sourceStreamToOutStream1 = new SourceStreamToOutStream();
        $sourceStreamToOutStream1->setSourceStream($sourceStream);
        $sourceStreamToOutStream1->setOutStream($outStream1);
        $this->em->persist($sourceStreamToOutStream1);

        $sourceStreamToOutStream2 = new SourceStreamToOutStream();
        $sourceStreamToOutStream2->setSourceStream($sourceStream);
        $sourceStreamToOutStream2->setOutStream($outStream2);
        $this->em->persist($sourceStreamToOutStream2);

        $item = new Item();
        $item->setProject($project);
        $item->setPublishedAt(new \DateTime());
        $item->setEffectivePublishedAt(new \DateTime());
        $this->em->persist($item);

        $this->em->flush();

        // TEST

        $action = new AddItemToStreamsAction($this->container);
        $action->go($sourceStream, $item);

        $repo = $this->em->getRepository('OpenCephalonBundle:OutStreamHasItem');

        $link1 = $repo->findOneBy(array('item'=>$item, 'outStream'=>$outStream1));
        $this->assertNotNull($link1);
        $this->assertNull($link1->getRemovedAt());

        $link2 = $repo->findOneBy(array('item'=>$item, 'outStream'=>$outStream2));
        $this->assertNotNull($link2);
        $this->assertNull($link1->getRemovedAt());

    }



    function testIfRemovedNotPutBack1() {


        $itemRepo = $this->em->getRepository('OpenCephalonBundle:Item');
        $outStreamHasItemRepo = $this->em->getRepository('OpenCephalonBundle:OutStreamHasItem');

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
        $item->setPublishedAt(new \DateTime());
        $item->setEffectivePublishedAt(new \DateTime());
        $this->em->persist($item);

        $this->em->flush();

        // RUN

        $action = new AddItemToStreamsAction($this->container);
        $action->go($sourceStream, $item);

        // TEST

        $this->assertTrue($itemRepo->isItemInOutStream($item, $outStream));


        // NOW REMOVE ITEM


        $link = $outStreamHasItemRepo->findOneBy(array('item'=>$item, 'outStream'=>$outStream));
        $link->setRemovedAt(new \DateTime('now'));
        $this->em->persist($link);
        $this->em->flush();


        // NOW RUN AGAIN


        $action = new AddItemToStreamsAction($this->container);
        $action->go($sourceStream, $item);


        // TEST IT DIDN'T ADD IT BACK!

        $this->assertFalse($itemRepo->isItemInOutStream($item, $outStream));
    }



    function testConditionMatches1() {

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

        $sourceStreamToOutStreamCondition = new SourceStreamToOutStreamCondition();
        $sourceStreamToOutStreamCondition->setPublicId('test');
        $sourceStreamToOutStreamCondition->setSourceStream($sourceStream);
        $sourceStreamToOutStreamCondition->setOutStream($outStream);
        $sourceStreamToOutStreamCondition->setContains('cat');
        $this->em->persist($sourceStreamToOutStreamCondition);

        $item = new Item();
        $item->setTitle('the cat sat on the mat');
        $item->setProject($project);
        $item->setPublishedAt(new \DateTime());
        $item->setEffectivePublishedAt(new \DateTime());
        $this->em->persist($item);

        $this->em->flush();

        // TEST

        $action = new AddItemToStreamsAction($this->container);
        $action->go($sourceStream, $item);

        $repo = $this->em->getRepository('OpenCephalonBundle:OutStreamHasItem');
        $links = $repo->findAll();

        $this->assertEquals(1, count($links));

        $link = $links[0];

        $this->assertEquals($outStream->getId(), $link->getOutStream()->getId());
        $this->assertEquals($item->getId(), $link->getItem()->getId());

    }


    function testConditionDoesNotMatch1() {

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

        $sourceStreamToOutStreamCondition = new SourceStreamToOutStreamCondition();
        $sourceStreamToOutStreamCondition->setPublicId('test');
        $sourceStreamToOutStreamCondition->setSourceStream($sourceStream);
        $sourceStreamToOutStreamCondition->setOutStream($outStream);
        $sourceStreamToOutStreamCondition->setContains('lizard');
        $this->em->persist($sourceStreamToOutStreamCondition);

        $item = new Item();
        $item->setTitle('the cat sat on the mat');
        $item->setProject($project);
        $item->setPublishedAt(new \DateTime());
        $item->setEffectivePublishedAt(new \DateTime());
        $this->em->persist($item);

        $this->em->flush();

        // TEST

        $action = new AddItemToStreamsAction($this->container);
        $action->go($sourceStream, $item);

        $repo = $this->em->getRepository('OpenCephalonBundle:OutStreamHasItem');
        $links = $repo->findAll();

        $this->assertEquals(0, count($links));

    }



}