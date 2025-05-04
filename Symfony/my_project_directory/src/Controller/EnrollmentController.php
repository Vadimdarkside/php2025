<?php

namespace App\Controller;

use App\Entity\Enrollments;
use App\Repository\ClientsRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\EnrollmentsRepository;
use App\Repository\WorkoutProgramsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    #[Route('/api/enrollments', methods: ['GET'], name: 'api_enrollments')]
    #[IsGranted('ROLE_MANAGER')]
    public function index(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $repo = $em->getRepository(Enrollments::class);
        $qb = $repo->createQueryBuilder('e')
            ->leftJoin('e.client_id', 'c')
            ->leftJoin('e.program_id', 'p')
            ->addSelect('c', 'p');

        if ($request->query->get('filter')) {
            if ($clientId = $request->query->get('client_id')) {
                $qb->andWhere('e.client_id = :client_id')
                ->setParameter('client_id', $clientId);
            }

            if ($programId = $request->query->get('program_id')) {
                $qb->andWhere('e.program_id = :program_id')
                ->setParameter('program_id', $programId);
            }

            if ($startDate = $request->query->get('start_date')) {
                $qb->andWhere('e.start_date >= :start_date')
                ->setParameter('start_date', $startDate);
            }

            if ($status = $request->query->get('status')) {
                $qb->andWhere('e.status LIKE :status')
                ->setParameter('status', '%' . $status . '%');
            }
        }

        $enrollments = $qb->getQuery()->getResult();

        $data = [];

        foreach ($enrollments as $enrollment) {
            $data[] = [
                'id' => $enrollment->getId(),
                'client' => $enrollment->getClientId()?->getEmail(),
                'program' => $enrollment->getProgramId()?->getName(),
                'start_date' => $enrollment->getStartDate()?->format('Y-m-d'),
                'status' => $enrollment->getStatus(),
            ];
        }

        return new JsonResponse($data);
    }

    #[Route('/api/enrollments/{id}', methods: ['GET'], name: 'api_enrollment_show')]
    #[IsGranted('ROLE_MANAGER')]
    public function show($id): JsonResponse
    {
        $enrollment = $this->enrollmentsRepository->find($id);

        if (!$enrollment) {
            return new JsonResponse(['error' => 'Запис не знайдено!'], 404);
        }

        $data = [
            'id' => $enrollment->getId(),
            'client' => [
                'id' => $enrollment->getClientId()?->getId(),
                'email' => $enrollment->getClientId()?->getEmail(),
            ],
            'program' => [
                'id' => $enrollment->getProgramId()?->getId(),
                'name' => $enrollment->getProgramId()?->getName(),
            ],
            'start_date' => $enrollment->getStartDate()?->format('Y-m-d'),
            'status' => $enrollment->getStatus(),
        ];

        return new JsonResponse($data);
    }

    #[Route('/api/enrollments/create', name: 'api_enrollments_create', methods: ['POST'])]
    #[IsGranted('ROLE_MANAGER')]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $clientId = $data['client_id'] ?? null;
        $programId = $data['program_id'] ?? null;
        $status = $data['status'] ?? 'Активний';
        $startDate = isset($data['start_date']) ? new \DateTime($data['start_date']) : new \DateTime();

        if (!$clientId || !$programId) {
            return new JsonResponse(['error' => 'Необхідно вказати client_id і program_id.'], 400);
        }

        $client = $this->clientsRepository->find($clientId);
        $program = $this->workoutProgramsRepository->find($programId);

        if (!$client || !$program) {
            return new JsonResponse(['error' => 'Клієнт або програма не знайдені.'], 404);
        }

        $enrollment = new Enrollments();
        $enrollment->setClientId($client);
        $enrollment->setProgramId($program);
        $enrollment->setStartDate($startDate);
        $enrollment->setStatus($status);

        $this->em->persist($enrollment);
        $this->em->flush();

        return new JsonResponse([
            'message' => 'Запис успішно створено!',
            'enrollment_id' => $enrollment->getId()
        ], 201);
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
