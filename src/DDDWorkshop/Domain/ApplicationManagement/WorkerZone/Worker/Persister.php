<?php

namespace DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Worker;

use DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Worker;

interface Persister
{
    public function persist(array $events);
}