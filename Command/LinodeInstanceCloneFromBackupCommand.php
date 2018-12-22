<?php

namespace TheRat\LinodeBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TheRat\LinodeBundle\Services\LinodeInstancesService;

class LinodeInstanceCloneFromBackupCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('linode:instances:clone-from-backup')
//            ->addArgument('linode-id', InputArgument::REQUIRED, 'ID of the Linode to look up')
            ->setDescription('Clone linode instance from backup');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Clone linode instance from backup');

        $service = $this->getContainer()->get(LinodeInstancesService::class);
        $response = $service->create('g6-nanode-1', 'eu-central', 107643675);

        var_dump($response);
    }
}