<?php

namespace App\Controller;

use App\Entity\Enrollments;
use App\Repository\EnrollmentsRepository;
use App\Repository\ClientsRepository;
use App\Repository\WorkoutProgramsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EnrollmentController extends AbstractController
{
    private $enrollmentsRepository;
    private $clientsRepository;
    private $workoutProgramsRepository;
    private $em;

    public function __construct(
        EnrollmentsRepository $repo,
        ClientsRepository $clientsRepo,
        WorkoutProgramsRepository $workoutProgramsRepo,
        EntityManagerInterface $manager
    ) {
        $this->enrollmentsRepository = $repo;
        $this->clientsRepository = $clientsRepo;
        $this->workoutProgramsRepository = $workoutProgramsRepo;
        $this->em = $manager;
    }

    #[Route('/enrollments', methods: ['GET'], name: 'enrollments')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $repo = $em->getRepository(Enrollments::class);
        $qb = $repo->createQueryBuilder('e');

        if ($request->query->get('filter')) {
            $client_id = $request->query->get('client_id');
            $program_id = $request->query->get('program_id');
            $start_date = $request->query->get('start_date');
            $status = $request->query->get('status');

            if ($client_id) {
                $qb->andWhere('e.client_id = :client_id')
                   ->setParameter('client_id', $client_id);
            }

            if ($program_id) {
                $qb->andWhere('e.program_id = :program_id')
                   ->setParameter('program_id', $program_id);
            }

            if ($start_date) {
                $qb->andWhere('e.start_date >= :start_date')
                   ->setParameter('start_date', $start_date);
            }

            if ($status) {
                $qb->andWhere('e.status LIKE :status')
                   ->setParameter('status', '%' . $status . '%');
            }

            $enrollments = $qb->getQuery()->getResult();
        } else {
            $enrollments = $repo->findAll();
        }

        return $this->render('lab4/enrolls.html.twig', [
            'enrollments' => $enrollments,
        ]);
    }

    #[Route('/enrollments/{id}', methods: ['GET'], name: 'enrollments_id')]
    public function show($id): Response
    {
        $enrollment = $this->enrollmentsRepository->find($id);
        if (!$enrollment) {
            return new Response('Запис не знайдено!', 404);
        }

        return $this->render('lab3GymView/showEnrollment.html.twig', [
            'enrollment' => $enrollment
        ]);
    }

    #[Route('/enrollments/create', name: 'enrollments_create')]
    public function create(Request $request): Response
    {
        $enrollment = new Enrollments();
        
        $client = $this->clientsRepository->find(1);  
        $workoutProgram = $this->workoutProgramsRepository->find(1);  
        
        $enrollment->setClientId($client);
        $enrollment->setProgramId($workoutProgram);
        $enrollment->setStartDate(new \DateTime());
        $enrollment->setStatus('Активний');
        
        $this->em->persist($enrollment);
        $this->em->flush();

        return new Response('Запис успішно створено!');
    }


    #[Route('/enrollments/update/{id}', name: 'enrollments_update')]
    public function update($id, Request $request): Response
    {
        $enrollment = $this->enrollmentsRepository->find($id);
        if (!$enrollment) {
            return new Response('Запис не знайдено!', 404);
        }

        $client = $this->clientsRepository->find(2);  
        $workoutProgram = $this->workoutProgramsRepository->find(2);  

        $enrollment->setClientId($client);
        $enrollment->setProgramId($workoutProgram);
        $enrollment->setStartDate(new \DateTime());
        $enrollment->setStatus('Завершений');
        
        $this->em->flush();

        return new Response('Запис успішно оновлено!');
    }


    #[Route('/enrollments/delete/{id}', name: 'enrollments_delete')]
    public function delete($id): Response
    {
        $enrollment = $this->enrollmentsRepository->find($id);

        if (!$enrollment) {
            return new Response('Запис не знайдено!', 404);
        }

        $this->em->remove($enrollment);
        $this->em->flush();

        return new Response('Запис успішно видалено!');
    }
}
