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
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $repo = $em->getRepository(Trainers::class);
        $qb = $repo->createQueryBuilder('t');

        if ($request->query->get('filter')) {
            $first_name = $request->query->get('first_name');
            $last_name = $request->query->get('last_name');
            $email = $request->query->get('email');
            $specialty = $request->query->get('specialty');

            if ($first_name) {
                $qb->andWhere('t.first_name LIKE :first_name')
                   ->setParameter('first_name', '%' . $first_name . '%');
            }

            if ($last_name) {
                $qb->andWhere('t.last_name LIKE :last_name')
                   ->setParameter('last_name', '%' . $last_name . '%');
            }

            if ($email) {
                $qb->andWhere('t.email LIKE :email')
                   ->setParameter('email', '%' . $email . '%');
            }

            if ($specialty) {
                $qb->andWhere('t.specialty LIKE :specialty')
                   ->setParameter('specialty', '%' . $specialty . '%');
            }

            $trainers = $qb->getQuery()->getResult();
        } else {
            $trainers = $repo->findAll();
        }

        return $this->render('lab4/trainers.html.twig', [
            'trainers' => $trainers,
        ]);
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
