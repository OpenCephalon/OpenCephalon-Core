<?php

namespace OpenCephalonBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Bundle\FrameworkBundle\Console\Application;



/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
abstract class BaseTestWithDataBase extends WebTestCase
{


    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    protected $container;

    protected $application;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        $this->container = static::$kernel->getContainer();
        $this->em = $this->container
            ->get('doctrine')
            ->getManager();

        $this->application = new Application(static::$kernel);
        $this->application->setAutoExit(false);
        $this->application->run(new StringInput('doctrine:schema:drop --force --quiet'));
        $this->application->run(new StringInput('doctrine:migrations:version  --no-interaction --delete --all --quiet'));
        $this->application->run(new StringInput('doctrine:migrations:migrate --no-interaction --quiet'));


    }



    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        if ($this->em) {
            $this->em->close();
        }
    }

}
