<?php


namespace OpenCephalonBundle\Command;

use OpenCephalonBundle\Action\ProcessSourceStreamURLAction;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 *  @license 3-clause BSD
 *  @link https://github.com/OpenCephalon/OpenCephalon-Core/blob/master/LICENSE.txt
 */
class ProcessCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('opencephalon:process')
            ->setDescription('Process')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $doctrine = $this->getContainer()->get('doctrine');

        $projectRepository = $doctrine->getRepository('OpenCephalonBundle:SourceStream');
        $processSourceStreamURLAction = new ProcessSourceStreamURLAction($this->getContainer());

        foreach($projectRepository->getActive() as $sourceStream) {
            $output->writeln('SourceStream '.$sourceStream->getUrl());
            $processSourceStreamURLAction->go($sourceStream);
        }

        $output->writeln('Done');

    }

}

