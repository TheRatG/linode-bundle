<?php

namespace TheRat\LinodeBundle\MessageHandler;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use TheRat\LinodeBundle\Event\CloneLinodeEventArgs;
use TheRat\LinodeBundle\Events;
use TheRat\LinodeBundle\Message\SwapIpv4Message;
use TheRat\LinodeBundle\Model\Networking\AssigmentCollection;
use TheRat\LinodeBundle\Model\Networking\AssigmentModel;
use TheRat\LinodeBundle\Services\LinodeInstancesService;
use TheRat\LinodeBundle\Services\NetworkingService;

class SwapIpv4Handler implements MessageHandlerInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var LinodeInstancesService
     */
    private $instancesService;
    /**
     * @var NetworkingService
     */
    private $networkingService;
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(
        LinodeInstancesService $instancesService,
        NetworkingService $networkingService,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->instancesService = $instancesService;
        $this->networkingService = $networkingService;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(SwapIpv4Message $message)
    {
        $this->logger->debug(vsprintf('Invoke SwapIpv4Message - firstLinodeId: %s, secondLinodeId: %s', [
            $message->getFirstLinodeId(),
            $message->getSecondLinodeId(),
        ]));

        $firstLinode = $this->instancesService->view($message->getFirstLinodeId());
        $secondLinode = $this->instancesService->view($message->getSecondLinodeId());

        if ($firstLinode && $secondLinode) {
            if ($firstLinode->getRegion() !== $secondLinode->getRegion()) {
                throw new \RuntimeException('Swapped linodes must be in the same region');
            }
            $this->eventDispatcher->dispatch(Events::preSwapIpv4,
                new CloneLinodeEventArgs($firstLinode, $secondLinode));

            $collection = new AssigmentCollection();

            foreach ($firstLinode->getIpv4() as $ipv4) {
                $assigment = new AssigmentModel();
                $assigment->setLinodeId($secondLinode->getId());
                $assigment->setAddress($ipv4);

                $collection->add($assigment);
            }

            foreach ($secondLinode->getIpv4() as $ipv4) {
                $assigment = new AssigmentModel();
                $assigment->setLinodeId($firstLinode->getId());
                $assigment->setAddress($ipv4);

                $collection->add($assigment);
            }

            $this->instancesService->shutdown($firstLinode->getId());
            $this->instancesService->shutdown($secondLinode->getId());
            
            $this->networkingService->ipv4Assign($firstLinode->getRegion(), $collection);
            $this->eventDispatcher->dispatch(Events::postSwapIpv4,
                new CloneLinodeEventArgs($firstLinode, $secondLinode));
            
            $this->instancesService->boot($secondLinode->getId());
        } else {
            throw new \RuntimeException('Linodes not found');
        }
    }
}