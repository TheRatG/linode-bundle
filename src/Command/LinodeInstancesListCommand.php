<?php

namespace TheRat\LinodeBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TheRat\LinodeBundle\Services\LinodeInstancesService;

class LinodeInstancesListCommand extends Command
{
    const NAME = 'linode:instances:list';
    const DESCRIPTION = 'Returns an array of all Linode instances on your Account.';

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
            ->addOption('page', null, InputOption::VALUE_REQUIRED, 1, 'The page of a collection to return.')
            ->addOption('page_size', null, InputOption::VALUE_REQUIRED, 100, 'The number of items to return per page.')
            ->setDescription(self::DESCRIPTION);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title(self::DESCRIPTION);

        $list = $this->instancesService->loadList(
            (int)$input->getOption('page'),
            (int)$input->getOption('page_size')
        );

        $tableRows = [];
        foreach ($list as $row) {
            $tableRows[] = [
                $row->getId(),
                $row->getLabel(),
                $row->getCreated()->format('Y-m-d H:i:s'),
                $row->getStatus(),
                $row->getType(),
                implode(', ', $row->getIpv4()),
            ];
        }
        $io->table(
            ['id', 'label', 'created', 'status', 'type', 'ipv4'],
            $tableRows
        );

        $io->section('Statistic');
        $io->table(['page', 'pages', 'results'], [
            [$list->getPage(), $list->getPages(), $list->getResults()],
        ]);
    }
}