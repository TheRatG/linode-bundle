<?php

namespace TheRat\LinodeBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use TheRat\LinodeBundle\Services\LinodeBackupsService;

class LinodeInstancesBackupsViewCommand extends Command
{
    const NAME = 'linode:instances:backups-view';
    const DESCRIPTION = 'Returns information about a Backup.';

    /**
     * @var LinodeBackupsService
     */
    private $backupsService;

    public function __construct(LinodeBackupsService $backupsService)
    {
        parent::__construct(self::NAME);

        $this->backupsService = $backupsService;
    }
    protected function configure()
    {
        $this
            ->addArgument('linode-id', InputArgument::REQUIRED, 'ID of the Linode to look up')
            ->addArgument('backup-id', InputArgument::REQUIRED, 'The ID of the Linode the Backup belongs to.')
            ->setDescription(self::DESCRIPTION);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title(self::DESCRIPTION);

        $linodeId = (int)$input->getArgument('linode-id');
        $backupId = (int)$input->getArgument('backup-id');
        $response = $this->backupsService->view($linodeId, $backupId);

        $jsonString = json_encode($response->toArray(), JSON_PRETTY_PRINT);
        $io->writeln($jsonString);
    }
}