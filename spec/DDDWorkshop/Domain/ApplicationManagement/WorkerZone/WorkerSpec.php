<?php

namespace spec\DDDWorkshop\Domain\ApplicationManagement\WorkerZone;

use DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Event\WorkerSubmitedApplication;
use DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Worker\Id;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class WorkerSpec extends ObjectBehavior
{
    function it_submits_application()
    {
        $this->beConstructedWith(Id::generate(),20);
        $this->submitApplication('2016-01-01','2016-01-20');

        $recentEvents = $this->getRecentEvents();
        $recentEvents->shouldHaveCount(1);
        $recentEvents[0]->shouldBeAnInstanceOf(WorkerSubmitedApplication::class);
        $recentEvents[0]->getApplicationStartDate()->shouldReturn('2016-01-01');
        $recentEvents[0]->getApplicationEndDate()->shouldReturn('2016-01-20');
    }
}
