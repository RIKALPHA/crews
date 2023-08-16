<?php

namespace App\Controller;

use App\Entity\Crew;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Serializer\SerializerInterface;

class UpdatePlanetController extends AbstractController
{
    public function __construct(private readonly MessageBusInterface $messageBus)
    {
    }

    public function __invoke(Request $request): Response
    {
        $content = $request->getContent();
        $json = json_decode($content, true);

        $planetId = $json['id'];
        $description = $json['description'];
        $status = $json['status'];

        $this->messageBus->dispatch(
            message: new PlanetUpdate($planetId, $description, $status)
        );

        return new Response('',200);
    }
}
