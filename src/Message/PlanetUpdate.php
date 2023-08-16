<?php

namespace App\Message;

class PlanetUpdate
{
    public function __construct(protected int $id)
    {

    }

    public function getPlanetId():int
    {
        return $this->id;
    }
}
