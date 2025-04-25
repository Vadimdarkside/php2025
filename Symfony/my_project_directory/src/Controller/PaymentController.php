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
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $repo = $em->getRepository(Payments::class);
        $qb = $repo->createQueryBuilder('p');

        if ($request->query->get('filter')) {
            $client_id = $request->query->get('client_id');
            $amount_min = $request->query->get('amount_min');
            $amount_max = $request->query->get('amount_max');
            $payment_date = $request->query->get('payment_date');
            $method = $request->query->get('method');

            if ($client_id) {
                $qb->andWhere('p.client_id = :client_id')
                   ->setParameter('client_id', $client_id);
            }

            if ($amount_min) {
                $qb->andWhere('p.amount >= :amount_min')
                   ->setParameter('amount_min', $amount_min);
            }

            if ($amount_max) {
                $qb->andWhere('p.amount <= :amount_max')
                   ->setParameter('amount_max', $amount_max);
            }

            if ($payment_date) {
                $qb->andWhere('p.payment_date >= :payment_date')
                   ->setParameter('payment_date', $payment_date);
            }

            if ($method) {
                $qb->andWhere('p.method LIKE :method')
                   ->setParameter('method', '%' . $method . '%');
            }

            $payments = $qb->getQuery()->getResult();
        } else {
            $payments = $repo->findAll();
        }

        return $this->render('lab4/payments.html.twig', [
            'payments' => $payments,
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
