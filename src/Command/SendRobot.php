<?php

namespace App\Command;

use App\Message\RobotTransmission;
use App\Repository\CrewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

//demo:crew 2 planet id 6
// php bin/console app:send -c 2 -p 6

#[AsCommand(
    name: "app:send"
)]
class SendRobot extends Command
{
    private EntityManagerInterface $entityManager;
    private CrewRepository $crewRepository;

    public function __construct(
        private readonly MessageBusInterface $messageBus,
        EntityManagerInterface $entityManager,
        CrewRepository $crewRepository
    )
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->crewRepository = $crewRepository;
    }

    protected function configure(): void
    {
        $this->addArgument('crewId', InputArgument::REQUIRED, 'Crew Id');
        $this->addArgument('planetId', InputArgument::REQUIRED, 'Planet Id');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $crewId = $input->getArgument('crewId');
        $planetId = $input->getArgument('planetId');

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
