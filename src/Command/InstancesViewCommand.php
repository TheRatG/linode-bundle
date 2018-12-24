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

class InstancesViewCommand extends Command
{
    const NAME = 'linode:instances:view';
    const DESCRIPTION = 'Get a specific Linode by ID.';

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
            ->addArgument('linode-id', InputArgument::REQUIRED, 'ID of the Linode to look up')
            ->setDescription(self::DESCRIPTION);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title(self::DESCRIPTION);

        $response = $this->instancesService->view((int)$input->getArgument('linode-id'));

        $jsonString = json_encode($response->toArray(), JSON_PRETTY_PRINT);
        $io->writeln($jsonString);
    }
}