<?php

namespace spec\DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Application;

use DDDWorkshop\Domain\Date;
use DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Exception\InvalidDatesException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DurationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Application\Duration');
    }

    function it_should_throw_an_exception_when_start_date_is_later_than_end_date()
    {
        $startDate = Date::fromString('2015-10-10');
        $endDate = Date::fromString('2015-09-10');

        $this->beConstructedThrough('fromDates', [$startDate, $endDate]);
        $this->shouldThrow(InvalidDatesException::class)->duringInstantiation();
    }

    function it_should_return_number_of_business_days()
    {
        $startDate = Date::fromString('2016-02-01');
        $endDate = Date::fromString('2016-02-14');

        $this->beConstructedThrough('fromDates', [$startDate, $endDate]);

        $this->getBusinessDays()->shouldReturn(10);
    }
}
