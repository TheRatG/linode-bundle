<?php

namespace TheRat\LinodeBundle\MessageHandler;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use TheRat\LinodeBundle\Message\LinodeBootMessage;
use TheRat\LinodeBundle\Model\Instances\LinodeModel;
use TheRat\LinodeBundle\Services\LinodeInstancesService;

class LinodeBootHandler implements MessageHandlerInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var LinodeInstancesService
     */
    private $instancesService;

    public function __construct(LinodeInstancesService $instancesService)
    {
        $this->instancesService = $instancesService;
    }

    public function __invoke(LinodeBootMessage $message)
    {
        $linode = $this->instancesService->view($message->getLinodeId());
        if ($linode && LinodeModel::STATUS_OFFLINE === $linode->getStatus()) {

            $this->logger->debug(sprintf('Boot linode %s', $linode->getId()));
            $this->instancesService->boot($linode->getId());

            do {
                $linode = $this->instancesService->view($linode->getId());
                $this->logger->debug(sprintf('Status is: %s', $linode->getStatus()));

                $booting = LinodeModel::STATUS_BOOTING === $linode->getStatus();
                if ($booting) {
                    sleep(5);
                }
            } while ($booting);

            $message->setLinode($linode);
        } else {
            $this->logger->notice(sprintf('Linode %s must be offline status', $linode->getId()));
        }
    }
}