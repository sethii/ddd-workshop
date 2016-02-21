<?php

namespace DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Command;

class SubmitApplication
{
    private $workerId;
    private $startDate;
    private $endDate;

    public function __construct($workerId, $startDate, $endDate)
    {
        $this->workerId = $workerId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @return mixed
     */
    public function getWorkerId()
    {
        return $this->workerId;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }
}