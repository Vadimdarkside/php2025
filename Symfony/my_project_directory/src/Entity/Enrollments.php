<?php

namespace App\Entity;

use App\Repository\EnrollmentsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnrollmentsRepository::class)]
class Enrollments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'enrollments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Clients $client_id = null;

    #[ORM\ManyToOne(inversedBy: 'enrollments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?WorkoutPrograms $program_id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(length: 50)]
    private ?string $status = null;

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

    public function getProgramId(): ?WorkoutPrograms
    {
        return $this->program_id;
    }

    public function setProgramId(?WorkoutPrograms $program_id): static
    {
        $this->program_id = $program_id;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }
}
