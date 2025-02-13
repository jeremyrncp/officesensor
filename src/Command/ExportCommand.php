<?php

namespace App\Command;

use App\Entity\Queue;
use App\Repository\QueueRepository;
use App\Service\ExportService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:export',
    description: 'Queue export',
)]
class ExportCommand extends Command
{
    public function __construct(
        private readonly QueueRepository $queueRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly ExportService $exportService
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $queues = $this->queueRepository->findBy(["processedAt" => null]);

        /** @var Queue $queue */
        foreach ($queues as $queue) {
            $exportData = $this->exportService->export($queue->getOrganization(), $queue->getStart(), $queue->getEnd());
            $concatenedDatas = array_merge($this->exportService->exportHeaders(), $exportData);

            $data = "";

            foreach ($concatenedDatas as $concatenedData) {
                $data .= implode(";", $concatenedData) . PHP_EOL;
            }

            file_put_contents(__DIR__ . "/../../public/export/" . $queue->getFileName() . ".csv", $data);

            $queue->setProcessedAt(new \DateTime());
        }

        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}
