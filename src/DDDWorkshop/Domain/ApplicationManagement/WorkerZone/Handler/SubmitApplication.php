<?php

namespace DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Handler;

use DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Worker\Persister;
use DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Worker\Repository;
use DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Command\SubmitApplication as SubmitApplicationCommand;

class SubmitApplication
{
    /**
     * @var Repository
     */
    private $workerRepository;
    private $persister;

    public function __construct(Repository $repository, Persister $persister)
    {
        $this->workerRepository = $repository;
        $this->persister = $persister;
    }

    public function handle(SubmitApplicationCommand $command)
    {
        $worker = $this->workerRepository->findById($command->getWorkerId());

        $worker->submitApplication($command->getStartDate(), $command->getEndDate());

        $this->persister->persist($worker->getRecentEvents());
    }
}