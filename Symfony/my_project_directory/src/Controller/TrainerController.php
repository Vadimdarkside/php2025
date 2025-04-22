<?php

namespace App\Controller;

use App\Entity\Trainers;
use App\Repository\TrainersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class TrainerController extends AbstractController
{
    private $trainersRepository;
    private $em;

    public function __construct(TrainersRepository $repo, EntityManagerInterface $manager)
    {
        $this->trainersRepository = $repo;
        $this->em = $manager;
    }

    #[Route('/trainers', methods: ['GET'], name: 'trainers')]
    public function index(): Response
    {
        $trainers = $this->trainersRepository->findAll();
        return $this->json($trainers);
    }

    #[Route('/trainers/create', name: 'trainers_create')]
    public function create(): Response
    {
        $trainer = new Trainers();
        $trainer->setFirstName('Олег');
        $trainer->setLastName('Петренко');
        $trainer->setSpecialty('Фітнес');
        $trainer->setEmail('oleg.petrenko@example.com');

        $this->em->persist($trainer);
        $this->em->flush();

        return new Response('Тренера успішно додано!');
    }

    #[Route('/trainers/update/{id}', name: 'trainers_update')]
    public function update($id): Response
    {
        $trainer = $this->trainersRepository->find($id);
        if (!$trainer) {
            return new Response('Тренера не знайдено!', 404);
        }
        $trainer->setFirstName('Новий');
        $trainer->setLastName('Тренер');
        $trainer->setSpecialty('Кросфіт');
        $trainer->setEmail('newtrainer@example.com');
        $this->em->flush();
        return new Response('Тренера успішно оновлено!');
    }

    #[Route('/trainers/delete/{id}', name: 'trainers_delete')]
    public function delete($id): Response
    {
        $trainer = $this->trainersRepository->find($id);
        if (!$trainer) {
            return new Response('Тренера не знайдено!', 404);
        }

        $this->em->remove($trainer);
        $this->em->flush();

        return new Response('Тренера успішно видалено!');
    }

    #[Route('/trainers/{id}', methods: ['GET'], name: 'trainer_show')]
    public function show($id): Response
    {
        $trainer = $this->trainersRepository->find($id);
        if (!$trainer) {
            return new Response('Тренера не знайдено!', 404);
        }

        return $this->json($trainer);
    }
}
