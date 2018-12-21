<?php

namespace TheRat\LinodeBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TheRat\LinodeBundle\Services\LinodeBackupsService;

class LinodeInstancesBackupsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('linode:instances:backups')
            ->addArgument('linode-id', InputArgument::REQUIRED, 'ID of the Linode to look up')
            ->setDescription('Returns information about this Linode\'s available backups.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $linodeId = (int)$input->getArgument('linode-id');

        $io = new SymfonyStyle($input, $output);
        $io->title('List Backups for ' . $linodeId);

        $service = $this->getContainer()->get(LinodeBackupsService::class);
        $response = $service->loadList($linodeId);

        $backups = [];
        foreach ($response->getData() as $item) {
            $backups[] = $this->extractData($item);
        }

        $io->table(
            array_keys(current($backups)),
            $backups
        );
    }

    protected function extractData(array $item)
    {
        return [
            'id' => $item['id'],
            'type' => $item['type'],
            'status' => $item['status'],
            'created' => $item['created'],
            'updated' => $item['updated'],
            'region' => $item['region'],
        ];
    }
}