<?php

namespace spec\DDDWorkshop\Domain;

use DDDWorkshop\Domain\Date;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use DDDWorkshop\Domain\Exception\InvalidDateFormatException;

class DateSpec extends ObjectBehavior
{
    function it_throws_an_exception_when_invalid_date_is_given()
    {
        $this->beConstructedThrough('fromString', ['invalid_date']);
        $this->shouldThrow(InvalidDateFormatException::class)->duringInstantiation();
    }

    function it_returns_zero_when_compared_to_same_date()
    {
        $this->beConstructedThrough('fromString',['2016-01-01']);
        $otherDate = Date::fromString('2016-01-01');

        $this->compareTo($otherDate)->shouldReturn(0);
    }

    function it_returns_minus_one_when_compared_to_later_date()
    {
        $this->beConstructedThrough('fromString',['2016-01-01']);
        $otherDate = Date::fromString('2016-01-02');

        $this->compareTo($otherDate)->shouldReturn(-1);
    }

    function it_returns_one_when_compared_to_sooner_date()
    {
        $this->beConstructedThrough('fromString',['2016-01-01']);
        $otherDate = Date::fromString('2015-01-01');

        $this->compareTo($otherDate)->shouldReturn(1);
    }

    function it_returns_range_between_two_dates()
    {
        $this->beConstructedThrough('fromString',['2016-01-01']);
        $otherDate = Date::fromString('2016-01-10');

        $expectedRange = new \DatePeriod(
            new \DateTimeImmutable('2016-01-01'),
            new \DateInterval('P1D'),
            new \DateTimeImmutable('2016-01-10')
        );

        $dateRange = $this->rangeBetween($otherDate);
        $dateRange->shouldBeLike($expectedRange);
    }
}
