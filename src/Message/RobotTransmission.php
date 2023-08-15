<?php

namespace App\Message;

class RobotTransmission
{
    public function __construct(protected int $id)
    {

    }

    public function getPlanetId():int
    {
        return $this->id;
    }
}
