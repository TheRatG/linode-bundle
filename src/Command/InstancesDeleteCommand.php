<?php

namespace TheRat\LinodeBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use TheRat\LinodeBundle\Services\LinodeInstancesService;

class InstancesDeleteCommand extends Command
{
    const NAME = 'linode:instances:delete';
    const DESCRIPTION = 'Delete Linode';

    /**
     * @var LinodeInstancesService
     */
    private $instancesService;

    public function __construct(LinodeInstancesService $instancesService)
    {
        parent::__construct(self::NAME);

        $this->instancesService = $instancesService;
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

        if ($io->confirm('Deleting a Linode is a destructive action and cannot be undone.', false)) {
            $this->instancesService->delete((int)$input->getArgument('linode-id'));
            $io->success('Success');
        }
    }
}