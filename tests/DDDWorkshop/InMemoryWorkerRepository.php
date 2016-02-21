<?php

namespace Tests\DDDWorkshop;

use DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Worker;
use DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Worker\Repository;

class InMemoryWorkerRepository implements Repository, Worker\Persister
{
    private $workers;
    /**
     * @param array $workers
     */
    public function __construct(array $workers)
    {
        $this->workers = $workers;
    }
    /** @return Worker */
    public function findById($id)
    {
        foreach ($this->workers as $worker) {
            if ($worker->getId()->isEqualTo(Worker\Id::fromString($id))) {
                return $worker;
            }
        }

        return null;
    }

    public function persist(array $events)
    {
        foreach ($events as $event) {
            foreach ($this->workers as $worker) {
                if ($worker->getId()->isEqualTo(Worker\Id::fromString($event->getWorkerId()))) {
                    $worker->addApplication($event->getApplicationId(), $event->getApplicationStartDate(), $event->getApplicationEndDate(), $event->getApplicationStatus());
                }
            }
        }
    }
}