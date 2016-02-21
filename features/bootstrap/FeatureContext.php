<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    const VALID_WORKER_ID = 'some_id';

    private $repository;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given there is a worker with id :arg1 and :arg2 available leave days
     */
    public function thereIsAWorkerWithIdAndAvailableLeaveDays($arg1, $arg2)
    {
        $this->repository = new \Tests\DDDWorkshop\InMemoryWorkerRepository([
            new \DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Worker(
                \DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Worker\Id::fromString($arg1),
                $arg2
            )
        ]);
    }

    /**
     * @When I submit leave application from :arg1 to :arg2
     */
    public function iSubmitLeaveApplicationFromTo($arg1, $arg2)
    {
        $handler = new \DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Handler\SubmitApplication(
            $this->repository,
            $this->repository
        );

        $command = new \DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Command\SubmitApplication(
            self::VALID_WORKER_ID,
            $arg1,
            $arg2
        );

        $handler->handle($command);
    }

    /**
     * @Then I should have submited application
     */
    public function iShouldHaveSubmitedApplication()
    {
        $worker = $this->repository->findById(self::VALID_WORKER_ID);
        if (empty($worker->getApplications())) {
            throw new RuntimeException('Application not submitted');
        }
    }
}
