<?php

namespace App\Entity;

use App\Repository\WorkoutProgramsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkoutProgramsRepository::class)]
class WorkoutPrograms
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $duration = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Trainers $Trainer = null;

    /**
     * @var Collection<int, Enrollments>
     */
    #[ORM\OneToMany(targetEntity: Enrollments::class, mappedBy: 'program_id', orphanRemoval: true)]
    private Collection $enrollments;

    public function __construct()
    {
        $this->enrollments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDuration(): ?float
    {
        return $this->duration;
    }

    public function setDuration(float $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getTrainer(): ?Trainers
    {
        return $this->Trainer;
    }

    public function setTrainer(?Trainers $Trainer): static
    {
        $this->Trainer = $Trainer;

        return $this;
    }

    /**
     * @return Collection<int, Enrollments>
     */
    public function getEnrollments(): Collection
    {
        return $this->enrollments;
    }

    public function addEnrollment(Enrollments $enrollment): static
    {
        if (!$this->enrollments->contains($enrollment)) {
            $this->enrollments->add($enrollment);
            $enrollment->setProgramId($this);
        }

        return $this;
    }

    public function removeEnrollment(Enrollments $enrollment): static
    {
        if ($this->enrollments->removeElement($enrollment)) {
            // set the owning side to null (unless already changed)
            if ($enrollment->getProgramId() === $this) {
                $enrollment->setProgramId(null);
            }
        }

        return $this;
    }
}
