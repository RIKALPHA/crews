<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\UpdatePlanetController;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/update',
            controller: UpdatePlanetController::class,
            description: "Update a planet's status and description"
        )
    ],
)]
class Planet
{
    public const STATUS_TODO = "TODO";
    public const STATUS_ENR = "En route";
    public const STATUS_OK = "OK";
    public const STATUS_NOK = "NOK";

    public const CORRELATION = [
        0 => self::STATUS_TODO,
        1 => self::STATUS_ENR,
        2 => self::STATUS_OK,
        3 => self::STATUS_NOK,
    ];

    public int $id;
    public ?string $description = null;
    #[Assert\Range(min: 2, max: 3)]
    public int $status = 1;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;

        return $this;
    }
}
