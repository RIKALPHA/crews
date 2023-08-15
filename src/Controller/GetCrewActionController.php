<?php

namespace App\Controller;

use App\Repository\CrewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class GetCrewActionController extends AbstractController
{
    private CrewRepository $crewRepository;
    private SerializerInterface $serializer;

    public function __construct(CrewRepository $crewRepository, SerializerInterface $serializer)
    {
        $this->crewRepository = $crewRepository;
        $this->serializer = $serializer;
    }

    public function __invoke(): Response
    {
        $crews = $this->crewRepository->findAll();

        return new Response($this->serializer->serialize($crews, 'json'),200);
    }
}
