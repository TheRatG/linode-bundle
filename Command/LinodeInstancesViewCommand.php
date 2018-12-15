<?php

namespace TheRat\LinodeBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TheRat\LinodeBundle\Services\LinodeInstancesService;

class LinodeInstancesViewCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('linode:instances:view')
            ->addArgument('linode-id', InputArgument::REQUIRED, 'ID of the Linode to look up')
            ->setDescription('Get a specific Linode by ID.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('View Linode');

        $service = $this->getContainer()->get(LinodeInstancesService::class);
        $response = $service->view((int)$input->getArgument('linode-id'));

        $jsonString = json_encode($response->getData(), JSON_PRETTY_PRINT);
        $io->writeln($jsonString);
    }
}