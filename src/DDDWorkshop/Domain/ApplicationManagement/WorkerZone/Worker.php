<?php

namespace DDDWorkshop\Domain\ApplicationManagement\WorkerZone;

use DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Event\WorkerSubmitedApplication;
use DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Exception\NotEnoughLeaveDaysException;
use DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Worker\Id;

class Worker
{
    private $id;
    private $availableLeaveDays;

    private $events = [];
    private $applications = [];

    public function __construct(Id $id, $availableLeaveDays)
    {
        $this->id = $id;
        $this->availableLeaveDays = $availableLeaveDays;
    }

    public function getId()
    {
        return $this->id;
    }

    public function addApplication($id, $startDate, $endDate, $status)
    {
        $this->applications[] = Application::create($id, $startDate, $endDate, $status);
    }

    public function submitApplication($startDate, $endDate)
    {
        $filledApplication = Application::fill($startDate, $endDate);

        $this->guardAvailableLeaveDays($filledApplication->getDurationInBusinessDays());
        $filledApplication->submit();

        $this->availableLeaveDays -= $filledApplication->getDurationInBusinessDays();

        $this->events[] = new WorkerSubmitedApplication(
            $this->id,
            $filledApplication
        );
    }

    private function guardAvailableLeaveDays($leaveDuration)
    {
        if ($leaveDuration > $this->availableLeaveDays) {
            throw new NotEnoughLeaveDaysException('You have not enough free leave days.');
        }
    }

    public function getApplications()
    {
        return $this->applications;
    }

    public function getRecentEvents()
    {
        $recentEvents = $this->events;
        $this->events = [];

        return $recentEvents;
    }
}