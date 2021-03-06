<?php

namespace TheRat\LinodeBundle\MessageHandler;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use TheRat\LinodeBundle\Event\CloneLinodeEventArgs;
use TheRat\LinodeBundle\Events;
use TheRat\LinodeBundle\Message\CreateByLastBackupMessage;
use TheRat\LinodeBundle\Model\Instances\BackupModel;
use TheRat\LinodeBundle\Model\Instances\LinodeModel;
use TheRat\LinodeBundle\Services\LinodeBackupsService;
use TheRat\LinodeBundle\Services\LinodeInstancesService;

class CreateByLastBackupHandler implements MessageHandlerInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;
    /**
     * @var LinodeInstancesService
     */
    private $instancesService;
    /**
     * @var LinodeBackupsService
     */
    private $backupsService;
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(
        LinodeInstancesService $instancesService,
        LinodeBackupsService $backupsService,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->instancesService = $instancesService;
        $this->backupsService = $backupsService;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(CreateByLastBackupMessage $message)
    {
        $message->getLinodeId();
        $this->logger->debug('Finding linode instance data...');
        $linode = $this->instancesService->view($message->getLinodeId());
        if ($linode->getId()) {
            $this->logger->debug(vsprintf(
                'Found data, label: %s, type: %s, region: %s', [
                    $linode->getLabel(),
                    $linode->getType(),
                    $linode->getRegion(),
                ]
            ));

            $this->logger->debug('Finding linode backups data...');
            $backups = $this->backupsService->loadList($linode->getId());
            $this->logger->debug(sprintf('Found %s backups', $backups->count()));

            if ($backups->count()) {
                /** @var BackupModel $backup */
                $backup = $backups->first();
                $this->logger->debug('Create new instance...');
                $cloneLabel = $this->buildLabel($linode->getLabel());

                $this->eventDispatcher->dispatch(Events::preCreateByLastBackup, new CloneLinodeEventArgs($linode));
                $newLinode = $this->instancesService->create(
                    $linode->getType(), $linode->getRegion(), $backup->getId(), $cloneLabel
                );
                $this->logger->debug(sprintf(
                    'Created, id: %s, label: %s', $newLinode->getId(), $newLinode->getLabel()
                ));

                do {
                    $this->logger->debug(sprintf('Status is: %s', $newLinode->getStatus()));
                    $restoring = in_array($newLinode->getStatus(), [
                        LinodeModel::STATUS_PROVISIONING,
                        LinodeModel::STATUS_RESTORING,
                    ]);

                    if ($restoring) {
                        sleep(5);
                        $newLinode = $this->instancesService->view($newLinode->getId());
                    }
                } while ($restoring);

                $this->logger->info(vsprintf('Copy complete, id: %s, label: %s, status %s', [
                    $newLinode->getId(),
                    $newLinode->getLabel(),
                    $newLinode->getStatus(),
                ]));
                $this->eventDispatcher->dispatch(Events::postCreateByLastBackup, new CloneLinodeEventArgs($linode));
                $message->setNewLinode($newLinode);
            }
        } else {
            new \RuntimeException('Linode not found');
        }
    }

    protected function buildLabel($sourceLabel, $try = 1)
    {
        $ar = explode('_', $sourceLabel);
        $last = array_pop($ar);
        if (is_numeric($last)) {
            $try = $last;
        } else {
            $ar[] = $last;
        }
        $last = $try + 1;

        array_push($ar, $last);
        $result = implode('_', $ar);

        if ($this->instancesService->viewByLabel($result)) {
            $result = $this->buildLabel($sourceLabel, $try + 1);
        }

        return $result;
    }
}