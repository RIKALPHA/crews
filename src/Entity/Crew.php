<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\AddCrewActionController;
use App\Controller\GetCrewActionController;
use App\Controller\UpdatePlanetController;
use App\Repository\CrewRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CrewRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/list',
            controller: GetCrewActionController::class,
            paginationEnabled: false
        ),
        new Post(
            uriTemplate: '/add',
            controller: AddCrewActionController::class
        )
    ],
    routePrefix: '/planets',
    normalizationContext: null,
    denormalizationContext: null
)]
class Crew
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $captainName = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    private array $robots = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCaptainName(): ?string
    {
        return $this->captainName;
    }

    public function setCaptainName(string $captainName): static
    {
        $this->captainName = $captainName;

        return $this;
    }

    public function getRobots(): array
    {
        return $this->robots;
    }

    public function setRobots(array $robots): static
    {
        $this->robots = $robots;

        return $this;
    }
}
