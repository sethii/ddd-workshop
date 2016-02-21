<?php

namespace DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Worker;

use DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Worker;

interface Repository
{
    /** @return Worker */
    public function findById($id);
}