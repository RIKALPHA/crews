<?php

namespace App\Command;

use App\Message\RobotTransmission;
use App\Repository\CrewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

//demo:6
//

#[AsCommand(
    name: "app:send"
)]
class SendRobot extends Command
{
    private EntityManagerInterface $entityManager;
    private CrewRepository $crewRepository;

    public function __construct(
        private readonly MessageBusInterface $messageBus,
        string $name = null,
        EntityManagerInterface $entityManager,
        CrewRepository $crewRepository
    )
    {
        parent::__construct($name);
        $this->entityManager = $entityManager;
        $this->crewRepository = $crewRepository;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $crewId = 'CrewId: ' . $input->getArgument('crewId');
        $planetId = 'PlanetId: ' . $input->getArgument('planetId');

        $crew = $this->crewRepository->find($crewId);
        if ($crew === null) {
            return Command::FAILURE;
        }

        $robots = $crew->getRobots();

        if (count($robots) === 0) {
            return Command::FAILURE;
        }

        //send this guy
        $robot = array_pop($robots);

        $crew->setRobots($robots);

        $this->entityManager->persist($crew);
        $this->entityManager->flush();


        $this->messageBus->dispatch(
            message: new RobotTransmission($planetId)
        );

        return Command::SUCCESS;
    }
}
