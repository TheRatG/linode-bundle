<?php

namespace TheRat\LinodeBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use TheRat\LinodeBundle\Model\Networking\AssigmentModel;
use TheRat\LinodeBundle\Model\Networking\AssigmentCollection;
use TheRat\LinodeBundle\Services\LinodeBackupsService;
use TheRat\LinodeBundle\Services\LinodeInstancesService;
use TheRat\LinodeBundle\Services\NetworkingService;

class LinodeInstancesCloneFromBackupCommand extends Command implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    protected $io;

    protected function configure()
    {
        $this
            ->setName('linode:instances:clone-from-backup')
            ->addArgument('linode-id', InputArgument::REQUIRED, 'ID of the Linode to look up')
            ->setDescription('Clone linode instance from backup');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Clone linode instance from backup');
        $this->io = $io;

        $linodeId = $input->getArgument('linode-id');
        $instancesService = $this->container->get(LinodeInstancesService::class);

        $io->writeln('Finding linode instance data...');
        $viewData = $instancesService->view($linodeId);
        $viewData = $viewData->getData();

        $sourceId = $viewData['id'];
        $sourceLabel = $viewData['label'];
        $sourceType = $viewData['type'];
        $sourceRegion = $viewData['region'];
        $sourceIpv4 = $viewData['ipv4'][0];
        $cloneLabel = $this->buildLabel($sourceLabel);
        $io->writeln(vsprintf(
            'Found data, label: %s, type: %s, region: %s', [
                $sourceLabel,
                $sourceType,
                $sourceRegion,
            ]
        ));

        $io->writeln('Finding linode backups data...');
        $backupService = $this->container->get(LinodeBackupsService::class);
        $backups = $backupService->loadList($linodeId);
        $io->writeln(sprintf('Found %s backups', count($backups)));

        if (!empty($backups)) {
            $backup = array_shift($backups);

            $io->section('Create new instance...');
//            $response = $instancesService->create($sourceType, $sourceRegion, $backup['id'], $cloneLabel);
//            $io->writeln(sprintf(
//                'Created, id: %s, label: %s', $response->getData()['id'], $response->getData()['label']
//            ));

            do {
                $cloneId = 12159854;
                $viewData = $instancesService->view($cloneId);
                $viewData = $viewData->getData();
                $cloneIpv4 = $viewData['ipv4'][0];

                $io->writeln(sprintf('Status is: %s', $viewData['status']));
                $restoring = 'restoring' === $viewData['status'];
                if ($restoring) {
                    sleep(5);
                }
            } while ($restoring);

            $io->section(sprintf('Boot linode %s', $cloneId));
            $instancesService->boot($cloneId);
            do {
                $viewData = $instancesService->view($cloneId);
                $viewData = $viewData->getData();

                $io->writeln(sprintf('Status is: %s', $viewData['status']));
                $booting = 'booting' === $viewData['status'];
                if ($booting) {
                    sleep(5);
                }
            } while ($booting);

            $io->section(vsprintf('Swap ip, source [%s:%s] -> clone [%s:%s]', [
                $sourceId,
                $sourceIpv4,
                $cloneId,
                $cloneIpv4,
            ]));

            $sourceAssigment = new AssigmentModel();
            $sourceAssigment->setLinodeId($sourceId);
            $sourceAssigment->setAddress($cloneIpv4);

            $cloneAssigment = new AssigmentModel();
            $cloneAssigment->setLinodeId($cloneId);
            $cloneAssigment->setAddress($sourceIpv4);

            $assigmentCollection = new AssigmentCollection([
                $sourceAssigment,
                $cloneAssigment,
            ]);
            $data = $this->container->get(NetworkingService::class)->ipv4Assign($sourceRegion, $assigmentCollection);
            var_dump($data);
        } else {
            $io->warning('No backups');
        }
    }

    protected function buildLabel($sourceLabel)
    {
        $ar = explode('_', $sourceLabel);
        $last = array_pop($ar);
        if (is_numeric($last)) {
            $last++;
        } else {
            $last = 1;
        }
        array_push($ar, $last);
        return implode('_', $ar);
    }
}