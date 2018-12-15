<?php

namespace TheRat\LinodeBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TheRat\LinodeBundle\Services\LinodeBackupsService;

class LinodeInstancesBackupsViewCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('linode:instances:backups:view')
            ->addArgument('linode-id', InputArgument::REQUIRED, 'ID of the Linode to look up')
            ->addArgument('backup-id', InputArgument::REQUIRED, 'The ID of the Linode the Backup belongs to.')
            ->setDescription('Returns information about a Backup.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('View Backup');

        $service = $this->getContainer()->get(LinodeBackupsService::class);
        $linodeId = (int)$input->getArgument('linode-id');
        $backupId = (int)$input->getArgument('backup-id');
        $response = $service->viewBackup($linodeId, $backupId);

        $jsonString = json_encode($response->getData(), JSON_PRETTY_PRINT);
        $io->writeln($jsonString);
    }
}