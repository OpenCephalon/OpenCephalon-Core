<?php


namespace OpenCephalonBundle\Command;

use OpenCephalonBundle\Action\OutStreamTweetAction;
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
class TweetCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('opencephalon:tweet')
            ->setDescription('Tweet')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $doctrine = $this->getContainer()->get('doctrine');

        $outStreamToTwitterRepository = $doctrine->getRepository('OpenCephalonBundle:OutStreamToTwitter');


        $twitterKey = $this->getContainer()->hasParameter('twitter_key') ? $this->getContainer()->getParameter('twitter_key') : null;
        $twitterKeySecret = $this->getContainer()->hasParameter('twitter_key_secret') ? $this->getContainer()->getParameter('twitter_key_secret') : null;

        if (!$twitterKey || !$twitterKeySecret) {
            $output->writeln('No Twitter Configured');
            return;
        }

        $action = new OutStreamTweetAction($this->getContainer());

        foreach($outStreamToTwitterRepository->findAll() as $outStreamToTwitter) {


            $output->writeln('ID '. $outStreamToTwitter->getId());

            $action->go($outStreamToTwitter);

        }

        $output->writeln('Done');

    }

}

