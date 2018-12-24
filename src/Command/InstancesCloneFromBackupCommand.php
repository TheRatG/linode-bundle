<?php

namespace TheRat\LinodeBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;
use TheRat\LinodeBundle\Message\CreateByLastBackupMessage;
use TheRat\LinodeBundle\Message\LinodeBootMessage;
use TheRat\LinodeBundle\Message\SwapIpv4Message;

class InstancesCloneFromBackupCommand extends Command
{
    const NAME = 'linode:instances:create-by-last-backup';
    const DESCRIPTION = 'Create linode instance by last backup';

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
            ->setName(self::NAME)
            ->addArgument('linode-id', InputArgument::REQUIRED, 'ID of the Linode to look up')
            ->setDescription(self::DESCRIPTION);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title(self::DESCRIPTION);

        $linodeId = (int)$input->getArgument('linode-id');

        $message = new CreateByLastBackupMessage($linodeId);
        $this->messageBus->dispatch($message);

        $newLinode = $message->getNewLinode();
        if ($newLinode) {
            $message = new LinodeBootMessage($newLinode->getId());
            $this->messageBus->dispatch($message);

            $newLinode = $message->getLinode();
            if ($newLinode) {
                $message = new SwapIpv4Message($linodeId, $newLinode->getId());
                $this->messageBus->dispatch($message);
            } else {
                $io->error('Invalid return data from boot message');
            }
        } else {
            $io->error(sprintf('Linode not found by id: %s', $linodeId));
        }
    }
}