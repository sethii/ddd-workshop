<?php

namespace DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Event;

use DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Application;
use DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Worker\Id as WorkerId;

class WorkerSubmitedApplication
{
    private $workerId;
    private $application;

    public function __construct(
        WorkerId $workerId,
        Application $application
    ) {
        $this->workerId = $workerId;
        $this->application = $application;
    }

    /**
     * @return mixed
     */
    public function getWorkerId()
    {
        return (string) $this->workerId;
    }

    /**
     * @return mixed
     */
    public function getApplicationId()
    {
        return (string) $this->application->getId();
    }

    /**
     * @return mixed
     */
    public function getApplicationStartDate()
    {
        return (string) $this->application->getStartDate();
    }

    /**
     * @return mixed
     */
    public function getApplicationEndDate()
    {
        return (string) $this->application->getEndDate();
    }

    /**
     * @return mixed
     */
    public function getApplicationStatus()
    {
        return $this->application->getStatus();
    }
}