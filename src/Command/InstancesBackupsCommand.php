<?php

namespace TheRat\LinodeBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TheRat\LinodeBundle\Services\LinodeBackupsService;

class InstancesBackupsCommand extends Command
{
    const NAME = 'linode:instances:backups-list';
    const DESCRIPTION = 'Returns information about this Linode\'s available backups.';

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
            ->setName('linode:instances:backups')
            ->addArgument('linode-id', InputArgument::REQUIRED, 'ID of the Linode to look up')
            ->setDescription(self::DESCRIPTION);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $linodeId = (int)$input->getArgument('linode-id');

        $io = new SymfonyStyle($input, $output);
        $io->title('List Backups for ' . $linodeId);

        $list = $this->backupsService->loadList($linodeId);

        $backups = [];
        foreach ($list as $item) {
            $backups[] = [
                'id' => $item->getId(),
                'type' => $item->getType(),
                'status' => $item->getStatus(),
                'created' => $item->getCreated()->format('Y-m-d H:i:s'),
                'updated' => $item->getUpdated()->format('Y-m-d H:i:s'),
            ];
        }

        $io->table(
            array_keys(current($backups)),
            $backups
        );
    }
}