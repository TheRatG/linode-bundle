<?php

namespace TheRat\LinodeBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;
use TheRat\LinodeBundle\Message\SwapIpv4Message;

class LinodeNetworkingSwapIpv4Command extends Command
{
    const NAME = 'linode:networking:swap-ipv4';
    const DESCRIPTION = 'Swap ips between two instances';

    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        parent::__construct(self::NAME);

        $this->messageBus = $messageBus;
    }

    protected function configure()
    {
        $this
            ->addArgument('first-linode-id', InputArgument::REQUIRED, 'First ID of the Linode to look up')
            ->addArgument('second-linode-id', InputArgument::REQUIRED, 'Second ID of the Linode to look up')
            ->setDescription(self::DESCRIPTION);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title(self::DESCRIPTION);

        $message = new SwapIpv4Message(
            (int)$input->getArgument('first-linode-id'),
            (int)$input->getArgument('second-linode-id')
        );
        $this->messageBus->dispatch($message);
    }
}