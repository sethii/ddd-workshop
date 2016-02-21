<?php

namespace DDDWorkshop\Domain\ApplicationManagement\WorkerZone\Worker;

class Id
{
    private $id;

    private function __construct($id)
    {
        $this->id = $id;
    }

    public static function generate()
    {
        return new self(uniqid());
    }

    public static function fromString($id)
    {
        return new self($id);
    }

    public function __toString()
    {
        return $this->id;
    }

    public function isEqualTo(Id $other)
    {
        return $this->id === $other->id;
    }
}