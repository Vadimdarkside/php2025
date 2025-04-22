<?php

namespace App\Controller;

use App\Entity\Payments;
use App\Repository\PaymentsRepository;
use App\Repository\ClientsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    private $paymentsRepository;
    private $clientsRepository;
    private $em;

    public function __construct(
        PaymentsRepository $paymentsRepository,
        ClientsRepository $clientsRepository,
        EntityManagerInterface $em
    ) {
        $this->paymentsRepository = $paymentsRepository;
        $this->clientsRepository = $clientsRepository;
        $this->em = $em;
    }

    #[Route('/payments', methods: ['GET'], name: 'payments')]
    public function index(): Response
    {
        $payments = $this->paymentsRepository->findAll();
        dd($payments);
        return $this->render('lab3GymView/payments.html.twig', [
            'payments' => $payments
        ]);
    }

    #[Route('/payments/{id}', methods: ['GET'], name: 'payments_id')]
    public function show($id): Response
    {
        $payment = $this->paymentsRepository->find($id);
        if (!$payment) {
            return new Response('Платіж не знайдено!', 404);
        }

        return $this->render('lab3GymView/showPayment.html.twig', [
            'payment' => $payment
        ]);
    }

    #[Route('/payments/create', name: 'payments_create')]
    public function create(Request $request): Response
    {
        $payment = new Payments();

        $client = $this->clientsRepository->find(1); 
        $payment->setClientId($client);
        $payment->setAmount('999.99');
        $payment->setPaymentDate(new \DateTime());
        $payment->setMethod('Готівка');

        $this->em->persist($payment);
        $this->em->flush();

        return new Response('Платіж успішно створено!');
    }

    #[Route('/payments/update/{id}', name: 'payments_update')]
    public function update($id, Request $request): Response
    {
        $payment = $this->paymentsRepository->find($id);
        if (!$payment) {
            return new Response('Платіж не знайдено!', 404);
        }

        $client = $this->clientsRepository->find(2);
        $payment->setClientId($client);
        $payment->setAmount('123.45');
        $payment->setPaymentDate(new \DateTime());
        $payment->setMethod('Карта');

        $this->em->flush();

        return new Response('Платіж успішно оновлено!');
    }

 
    #[Route('/payments/delete/{id}', name: 'payments_delete')]
    public function delete($id): Response
    {
        $payment = $this->paymentsRepository->find($id);

        if (!$payment) {
            return new Response('Платіж не знайдено!', 404);
        }

        $this->em->remove($payment);
        $this->em->flush();

        return new Response('Платіж успішно видалено!');
    }
}
