<?php

namespace App\Controller;

use App\Entity\WorkoutPrograms;
use App\Repository\WorkoutProgramsRepository;
use App\Repository\TrainersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class WorkoutProgramController extends AbstractController
{
    private $workoutProgramsRepository;
    private $trainersRepository;
    private $em;

    public function __construct(WorkoutProgramsRepository $repo, TrainersRepository $trainersRepo, EntityManagerInterface $manager)
    {
        $this->workoutProgramsRepository = $repo;
        $this->trainersRepository = $trainersRepo;
        $this->em = $manager;
    }

    #[Route('/workout-programs', methods: ['GET'], name: 'workout_programs')]
    public function index(): Response
    {
        $workoutPrograms = $this->workoutProgramsRepository->findAll();
        dd($workoutPrograms);
        return $this->render('lab3GymView/index.html.twig', [
            'workoutPrograms' => $workoutPrograms
        ]);
    }

    #[Route('/workout-programs/{id}', methods: ['GET'], name: 'workout_programs_id')]
    public function show($id): Response
    {
        $workoutProgram = $this->workoutProgramsRepository->find($id);
        if (!$workoutProgram) {
            return new Response('Програми тренувань не знайдено!', 404);
        }

        return $this->render('lab3GymView/showWorkoutProgram.html.twig', [
            'workoutProgram' => $workoutProgram
        ]);
    }

    #[Route('/workout-programs/create', name: 'workout_programs_create')]
    public function create(Request $request): Response
    {
        $workoutProgram = new WorkoutPrograms();
        
        $workoutProgram->setName('Тренування для початківців');
        $workoutProgram->setDescription('Програма для початківців, орієнтована на кардіо');
        $workoutProgram->setDuration(60);  

        $trainer = $this->trainersRepository->find(1);  
        $workoutProgram->setTrainer($trainer);
        
        $this->em->persist($workoutProgram);
        $this->em->flush();

        return new Response('Програму тренувань успішно додано!');
    }

    #[Route('/workout-programs/update/{id}', name: 'workout_programs_update')]
    public function update($id, Request $request): Response
    {
        $workoutProgram = $this->workoutProgramsRepository->find($id);
        if (!$workoutProgram) {
            return new Response('Програми тренувань не знайдено!', 404);
        }


        $workoutProgram->setName('Нове тренування для просунутих');
        $workoutProgram->setDescription('Програма для досвідчених користувачів, орієнтована на силові тренування');
        $workoutProgram->setDuration(90);  

        $trainer = $this->trainersRepository->find(2);  
        $workoutProgram->setTrainer($trainer);
        
        $this->em->flush();

        return new Response('Програму тренувань успішно оновлено!');
    }

    #[Route('/workout-programs/delete/{id}', name: 'workout_programs_delete')]
    public function delete($id): Response
    {
        $workoutProgram = $this->workoutProgramsRepository->find($id);

        if (!$workoutProgram) {
            return new Response('Програми тренувань не знайдено!', 404);
        }

        $this->em->remove($workoutProgram);
        $this->em->flush();

        return new Response('Програму тренувань успішно видалено!');
    }
}
