<?php

namespace App\Controller;

use App\Entity\Crew;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class AddCrewActionController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private SerializerInterface $serializer;

    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    public function __invoke(Request $request): Response
    {
        $content = $request->getContent();
        $json = json_decode($content, true);

        $captainName = $json['captainName'];
        $robots = $json['robots'] ?? null;

        $crew = new Crew();
        $crew->setCaptainName($captainName);
        $crew->setRobots($robots);

        $this->entityManager->persist($crew);
        $this->entityManager->flush();

        return new Response($this->serializer->serialize($crew, 'json'),200);
    }
}
