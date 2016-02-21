<?php

namespace spec\DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Handler;

use DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Command\SubmitApplication;
use DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Worker;
use DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Worker\Persister;
use DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Worker\Repository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SubmitApplicationSpec extends ObjectBehavior
{
    function it_handles_application_submit(
        Repository $repository,
        Persister $persister
    ) {
        $worker = new Worker(
            Worker\Id::generate(),
            26
        );
        $repository->findById('some_id')->willReturn($worker);

        $this->beConstructedWith($repository, $persister);

        $command = new SubmitApplication('some_id','2016-01-01','2016-01-10');

        $this->handle($command);

        $persister->persist(Argument::any())->shouldBeCalled();
    }
}
