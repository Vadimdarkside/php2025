<?php

namespace App\Entity;

use App\Repository\PaymentsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentsRepository::class)]
class Payments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'payments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Clients $client_id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 7, scale: 2)]
    private ?string $amount = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $payment_date = null;

    #[ORM\Column(length: 50)]
    private ?string $method = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientId(): ?Clients
    {
        return $this->client_id;
    }

    public function setClientId(?Clients $client_id): static
    {
        $this->client_id = $client_id;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getPaymentDate(): ?\DateTimeInterface
    {
        return $this->payment_date;
    }

    public function setPaymentDate(\DateTimeInterface $payment_date): static
    {
        $this->payment_date = $payment_date;

        return $this;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function setMethod(string $method): static
    {
        $this->method = $method;

        return $this;
    }
}
