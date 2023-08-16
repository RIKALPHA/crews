<?php

namespace App\Message;

class PlanetUpdate
{
    public function __construct(protected int $id, protected string $description, protected int $status)
    {
    }

    public function getId():int
    {
        return $this->id;
    }
    public function getDescription():string
    {
        return $this->description;
    }
    public function getStatus():int
    {
        return $this->status;
    }
}
