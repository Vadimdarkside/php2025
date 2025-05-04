<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Form\ClientFormType;
use App\Repository\ClientsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientsController extends AbstractController
{
    private $clientsRepository;
    private $em;
    private $security;
    public function __construct(ClientsRepository $repo, EntityManagerInterface $manager,Security $secur)
    {
        $this->clientsRepository = $repo;
        $this->em = $manager;
        $this->security = $secur;
    }

    #[Route('/api/clients',methods:['GET'], name:'clients')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(Request $request, EntityManagerInterface $em): Response
{
    
    $repo = $em->getRepository(Clients::class);
    $qb = $repo->createQueryBuilder('c');

    $filters = [];
    if ($request->query->get('filter')) {
        $first_name = $request->query->get('first_name');
        $last_name = $request->query->get('last_name');
        $email = $request->query->get('email');
        $phone = $request->query->get('phone');
        $registration_date = $request->query->get('registration_date');

        if ($first_name) {
            $qb->andWhere('c.first_name LIKE :first_name')
               ->setParameter('first_name', '%' . $first_name . '%');
            $filters['first_name'] = $first_name;
        }

        if ($last_name) {
            $qb->andWhere('c.last_name LIKE :last_name')
               ->setParameter('last_name', '%' . $last_name . '%');
            $filters['last_name'] = $last_name;
        }

        if ($email) {
            $qb->andWhere('c.email LIKE :email')
               ->setParameter('email', '%' . $email . '%');
            $filters['email'] = $email;
        }

        if ($phone) {
            $qb->andWhere('c.phone LIKE :phone')
               ->setParameter('phone', '%' . $phone . '%');
            $filters['phone'] = $phone;
        }

        if ($registration_date) {
            $year = $registration_date;
            $startDate = new \DateTime("$year-01-01");
            $endDate = new \DateTime("$year-12-31 23:59:59");

            $qb->andWhere('c.registration_date BETWEEN :start AND :end')
               ->setParameter('start', $startDate)
               ->setParameter('end', $endDate);
            $filters['registration_date'] = $registration_date;
        }
    }

    $page = max(1, (int)$request->query->get('page', 1));
    $limit = (int)$request->query->get('limit', 5);
    $offset = ($page - 1) * $limit;

    $qb->setFirstResult($offset)
       ->setMaxResults($limit);

    $paginator = new Paginator($qb->getQuery());
    $totalItems = count($paginator);
    $totalPages = ceil($totalItems / $limit);

    $clientData = [];
    foreach ($paginator as $client) {
        $clientData[] = [
            'id' => $client->getId(),
            'firstName' => $client->getFirstName(),
            'lastName' => $client->getLastName(),
            'email' => $client->getEmail(),
            'roles' => $client->getRoles(),
            'phone' => $client->getPhone(),
            'registrationDate' => $client->getRegistrationDate()?->format('Y-m-d'),
        ];
    }

    return $this->json([
        'data' => $clientData,
        'pagination' => [
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'limit' => $limit,
            'totalItems' => $totalItems
        ],
        'filters' => $filters,
    ]);
}
   
#[Route('api/clients/create', name: 'clients_create', methods: ['POST'])]
#[IsGranted('ROLE_ADMIN')]
public function create(Request $request, UserPasswordHasherInterface $passwordHasher): JsonResponse
{
    $data = json_decode($request->getContent(), true);

    if (!$data) {
        return new JsonResponse(['error' => 'Invalid JSON'], 400);
    }

    $client = new Clients();
    $client->setFirstName($data['first_name'] ?? '');
    $client->setLastName($data['last_name'] ?? '');
    $client->setEmail($data['email'] ?? '');
    $client->setPhone($data['phone'] ?? null);
    $client->setRegistrationDate(new \DateTime());
    $roles = $data['roles'] ?? ['ROLE_CLIENT'];
    $client->setRoles($roles);
    if (empty($data['password'])) {
        return new JsonResponse(['error' => 'Password is required'], 400);
    }
    $hashedPassword = $passwordHasher->hashPassword($client, $data['password']);
    $client->setPassword($hashedPassword);
    $this->em->persist($client);
    $this->em->flush();

    return new JsonResponse([
        'message' => 'Client created successfully',
        'client' => [
            'id' => $client->getId(),
            'first_name' => $client->getFirstName(),
            'last_name' => $client->getLastName(),
            'email' => $client->getEmail(),
            'roles' => $client->getRoles(),
        ]
    ], 201);
}

#[Route('/api/clients/update/{id}', name: 'clients_update', methods: ['PUT'])]
#[IsGranted('ROLE_ADMIN')]
public function update($id, Request $request): JsonResponse
{
    $client = $this->clientsRepository->find($id);

    if (!$client) {
        return new JsonResponse(['error' => 'Клієнта не знайдено'], 404);
    }

    $data = json_decode($request->getContent(), true);
    if (!$data) {
        return new JsonResponse(['error' => 'Некоректний JSON'], 400);
    }

    if (isset($data['first_name'])) {
        $client->setFirstName($data['first_name']);
    }
    if (isset($data['last_name'])) {
        $client->setLastName($data['last_name']);
    }
    if (isset($data['email'])) {
        $client->setEmail($data['email']);
    }
    if (isset($data['phone'])) {
        $client->setPhone($data['phone']);
    }
    if (isset($data['registration_date'])) {
        try {
            $date = new \DateTime($data['registration_date']);
            $client->setRegistrationDate($date);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Невірний формат дати'], 400);
        }
    }

    $this->em->flush();

    return new JsonResponse([
        'message' => 'Клієнта успішно оновлено',
        'client' => [
            'id' => $client->getId(),
            'first_name' => $client->getFirstName(),
            'last_name' => $client->getLastName(),
            'email' => $client->getEmail(),
            'phone' => $client->getPhone(),
            'registration_date' => $client->getRegistrationDate()?->format('Y-m-d'),
        ]
    ]);
}

#[Route('/api/clients/delete/{id}', name: 'clients_delete', methods: ['DELETE'])]
#[IsGranted('ROLE_ADMIN')]
public function delete(int $id): JsonResponse
{
    $client = $this->clientsRepository->find($id);

    if (!$client) {
        return new JsonResponse(['error' => 'Клієнта не знайдено'], 404);
    }

    $this->em->remove($client);
    try {
        $this->em->flush();
    } catch (\Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException $e) {
        return new JsonResponse([
            'error' => 'Неможливо видалити клієнта: повʼязаний з оплатами або іншими даними.'
        ], 409);
    }
    return new JsonResponse(['message' => 'Клієнта успішно видалено']);
}



    #[Route('api/client/me',methods:['GET'], name:'me')]
    #[IsGranted('ROLE_USER')]
    public function me():Response
    {
        $client = $this->security->getUser();
        if (!$client) {
            return $this->json(['error' => 'Not authenticated'], 401);
        }
        return $this->json([
        'id' => $client->getId(),
        'firstName' => $client->getFirstName(),
        'lastName' => $client->getLastName(),
        'email' => $client->getEmail(),
        'roles' => $client->getRoles(),
        'phone' => $client->getPhone(),
        'registrationDate' => $client->getRegistrationDate()?->format('Y-m-d')]);
    }

    

}

