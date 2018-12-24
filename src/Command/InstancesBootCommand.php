<?php

namespace TheRat\LinodeBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;
use TheRat\LinodeBundle\Message\LinodeBootMessage;

class InstancesBootCommand extends Command
{
    const NAME = 'linode:instances:boot';
    const DESCRIPTION = 'Boots a Linode you have permission to modify.';

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
        $message = new LinodeBootMessage($linodeId);
        $this->messageBus->dispatch($message);

        $io->success('Success');
    }
}