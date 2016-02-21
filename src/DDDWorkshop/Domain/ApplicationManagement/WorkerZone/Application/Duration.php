<?php

namespace DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Application;

use DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Exception\InvalidDatesException;
use DDDWorkshop\Domain\Date;

class Duration
{
    private $startDate;
    private $endDate;

    private function __construct(Date $startDate, Date $endDate)
    {
        $this->guardDates($startDate, $endDate);
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public static function fromDates(Date $startDate, Date $endDate)
    {
        return new self($startDate, $endDate);
    }

    /**
     * @param Date $startDate
     * @param Date $endDate
     * @throws InvalidDatesException
     */
    private function guardDates(Date $startDate, Date $endDate)
    {
        if ($startDate->compareTo($endDate) === Date::SOONER) {
            throw new InvalidDatesException('Start date cannot be later than end date');
        }
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @return int
     */
    public function getBusinessDays()
    {
        $range = $this->startDate->rangeBetween($this->endDate);

        $businessDays = 0;
        foreach($range as $date) {
            if ($date->format('w') > 0 && $date->format('w') < 6) {
                $businessDays++;
            }
        }

        return $businessDays;
    }
}
