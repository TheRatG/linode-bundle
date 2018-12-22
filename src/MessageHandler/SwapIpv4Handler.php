<?php

namespace TheRat\LinodeBundle\MessageHandler;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use TheRat\LinodeBundle\Message\SwapIpv4Message;
use TheRat\LinodeBundle\Services\LinodeInstancesService;
use TheRat\LinodeBundle\Services\NetworkingService;

class SwapIpv4Handler implements MessageHandlerInterface
{
    /**
     * @var LinodeInstancesService
     */
    private $instancesService;
    /**
     * @var NetworkingService
     */
    private $networkingService;

    public function __construct(LinodeInstancesService $instancesService, NetworkingService $networkingService)
    {
        $this->instancesService = $instancesService;
        $this->networkingService = $networkingService;
    }

    public function __invoke(SwapIpv4Message $message)
    {
        $this->instancesService->view($message->getFirstLinodeId());
    }
}