<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Form\ClientFormType;
use App\Repository\ClientsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientsController extends AbstractController
{
    private $clientsRepository;
    private $em;
    public function __construct(ClientsRepository $repo, EntityManagerInterface $manager)
    {
        $this->clientsRepository = $repo;
        $this->em = $manager;
    }

    #[Route('/clients',methods:['GET'], name:'clients')]
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

    return $this->render('lab4/clients.html.twig', [
        'clients' => $paginator,
        'currentPage' => $page,
        'totalPages' => $totalPages,
        'limit' => $limit,
        'filters' => $filters,
    ]);
}
   
    #[Route('/clients/create', name:'clients_create')]
    public function create(Request $request):Response
    {
        $client = new Clients();
        // $client->setFirstName('Іван');
        // $client->setLastName('Коваленко');
        // $client->setEmail('ivan@gmail.com');
        // $client->setPhone('+380501112233');
        // $client->setRegistrationDate(new \DateTime());
        
        $form = $this->createForm(ClientFormType::class,$client);//Такий підхід використав лише раз
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $newClient = $form->getData();
            $this->em->persist($newClient);
            $this->em->flush();
        }
        
        return $this->render('lab3GymView/ClientCreate.html.twig',
        [
            'form'=>$form->createView()
        ]);
    }

    #[Route('/clients/update/{id}', name: 'clients_update')]
    public function update($id, Request $request): Response
    {
        $client = $this->clientsRepository->find($id);
        if (!$client) {
            return new Response('Клієнта не знайдено!', 404);
        }
        $client->setFirstName('NewName');
        $client->setLastName('NewLast');
        $client->setEmail('new_email@example.com');
        $client->setPhone('+380991112233');
        $client->setRegistrationDate(new \DateTime());
        $this->em->flush(); 

        return new Response('Клієнта успішно оновлено!');
    }

    #[Route('/clients/delete/{id}', name: 'clients_delete')]
    public function delete($id): Response
    {
        $client = $this->clientsRepository->find($id);

        if (!$client) {
            return new Response('Клієнта не знайдено!', 404);
        }

        $this->em->remove($client);
        $this->em->flush();

        return new Response('Клієнта успішно видалено!');
    }



    #[Route('/clients/{id}',methods:['GET'], name:'clientsId')]
    public function show($id):Response
    {
        $client = $this->clientsRepository->find($id);
        dd($client);
        return $this->render('lab3GymView/index.html.twig',
    [
        'clients'=>$client
    ]);
    }

    

}

