<?php

namespace TheRat\LinodeBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use TheRat\LinodeBundle\Services\LinodeInstancesService;

class LinodeInstancesListCommand extends Command implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    protected function configure()
    {
        $this
            ->setName('linode:instances:list')
            ->addOption('page', null, InputOption::VALUE_REQUIRED, 1, 'The page of a collection to return.')
            ->addOption('page_size', null, InputOption::VALUE_REQUIRED, 100, 'The number of items to return per page.')
            ->setDescription('Returns an array of all Linodes on your Account.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('List Linodes');

        $service = $this->container->get(LinodeInstancesService::class);
        $response = $service->loadList((int)$input->getOption('page'), (int)$input->getOption('page_size'));

        $tableRows = [];
        foreach ($response->getData() as $row) {
            $data = $row->getData();
            $tableRows[] = [
                $data['id'],
                $data['label'],
                $data['created'],
                $data['status'],
                $data['type'],
                implode(', ', $data['ipv4']),
            ];
        }
        $io->table(
            ['id', 'label', 'created', 'status', 'type', 'ipv4'],
            $tableRows
        );

        $io->section('Statistic');
        $io->table(['page', 'pages', 'results'], [
            [$response->getPage(), $response->getPages(), $response->getResults()],
        ]);
    }
}