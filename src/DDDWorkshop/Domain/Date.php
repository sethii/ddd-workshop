<?php

namespace DDDWorkshop\Domain;

use DDDWorkshop\Domain\Exception\InvalidDateFormatException;

class Date
{
    const SOONER = 1;
    const SAME = 0;
    const LATER = -1;

    /**
     * @var \DateTimeImmutable
     */
    private $date;

    /**
     * @param string $date
     */
    private function __construct($date)
    {
        $this->guardFormat($date);
        $this->date = new \DateTimeImmutable($date);
    }

    /**
     * @param $date
     * @return Date
     */
    public static function fromString($date)
    {
        return new self($date);
    }

    public function __toString()
    {
        return $this->date->format('Y-m-d');
    }

    /**
     * @param $date
     * @throws InvalidDateFormatException
     */
    private function guardFormat($date)
    {
        if (! (bool) strtotime($date)) {
            throw new InvalidDateFormatException("You must type valid date");
        }
    }

    /**
     * @param Date $other
     * @return int
     */
    public function compareTo(Date $other)
    {
        $diff = $this->date->diff($other->date);

        if ($diff->invert === 0 && $diff->days > 0) {
            return self::LATER;
        } else if ($diff->invert === 1) {
            return self::SOONER;
        }

        return self::SAME;
    }

    /**
     * @param Date $other
     * @return \DatePeriod
     */
    public function rangeBetween(Date $other)
    {
        $interval = new \DateInterval('P1D');
        return new \DatePeriod($this->date, $interval, $other->date);
    }
}
