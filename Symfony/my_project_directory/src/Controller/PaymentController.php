<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Form\ClientFormType;
use App\Repository\ClientsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
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
    public function index():Response
    {
        $clients = $this->clientsRepository->findAll();
        dd($clients);
        return $this->render('lab3GymView/index.html.twig',
    [
        'clients'=>$clients
    ]);
    }

    #[Route('/clients/create', name:'clients_create')]
    public function create(Request $request):Response
    {
        $client = new Clients();
        $client->setFirstName('Іван');
        $client->setLastName('Коваленко');
        $client->setEmail('ivan@gmail.com');
        $client->setPhone('+380501112233');
        $client->setRegistrationDate(new \DateTime());
    
        $this->em->persist($client);
        $this->em->flush();
        // $form = $this->createForm(ClientFormType::class,$client);
        // $form->handleRequest($request);
        // if($form->isSubmitted() && $form->isValid())
        // {
        //     $newClient = $form->getData();
        //     dd($newClient);
        //     exit;
        // }

        return new Response('Клієнта успішно додано!',
    // [
    //     'form'=>$form->createView()
    // ]
    );
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

