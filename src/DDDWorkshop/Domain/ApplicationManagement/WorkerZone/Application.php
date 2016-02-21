<?php

namespace DDDWorkshop\Domain\ApplicationManagement\WorkerZone;

use DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Application\Duration;
use DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Application\Id;
use DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Exception\ApplicationNotFilledException;
use DDDWorkshop\Domain\Date;

class Application
{
    const FILLED = 0;
    const SUBMITED = 1;

    private $duration;
    private $status;

    private function __construct(Id $id, Duration $duration, $status)
    {
        $this->id = $id;
        $this->duration = $duration;
        $this->status = $status;
    }

    public static function create($id, $startDate, $endDate, $status)
    {
        return new self (
            Id::fromString($id),
            Duration::fromDates(
                Date::fromString($startDate),
                Date::fromString($endDate)
            ),
            $status
        );
    }

    public static function fill($startDate, $endDate)
    {
        return new self (
            Id::generate(),
            Duration::fromDates(
                Date::fromString($startDate),
                Date::fromString($endDate)
            ),
            self::FILLED
        );
    }

    public function submit()
    {
        if ($this->status !== self::FILLED) {
            throw new ApplicationNotFilledException('Application must be filled before it can be submited');
        }

        $this->status = self::SUBMITED;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getDurationInBusinessDays()
    {
        return $this->duration->getBusinessDays();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getStartDate()
    {
        return $this->duration->getStartDate();
    }

    public function getEndDate()
    {
        return $this->duration->getEndDate();
    }
}
