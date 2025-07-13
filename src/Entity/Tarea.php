<?php

namespace App\Entity;

use App\Repository\TareaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TareaRepository::class)]
class Tarea
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $titulo = null;

    #[ORM\Column(length: 100)]
    private ?string $descripcion = null;

    #[ORM\Column]
    private ?\DateTime $fecha_creacion = null;

    #[ORM\Column]
    private ?\DateTime $fecha_final = null;

    #[ORM\Column(nullable: true)]
    private ?bool $estado = null;

    #[ORM\ManyToOne(inversedBy: 'tareas')]
    private ?Tipo $tipo = null;

    /**
     * @var Collection<int, Admin>
     */
    #[ORM\ManyToMany(targetEntity: Admin::class, inversedBy: 'tareas')]
    private Collection $user;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): static
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getFechaCreacion(): ?\DateTime
    {
        return $this->fecha_creacion;
    }

    public function setFechaCreacion(\DateTime $fecha_creacion): static
    {
        $this->fecha_creacion = $fecha_creacion;

        return $this;
    }

    public function getFechaFinal(): ?\DateTime
    {
        return $this->fecha_final;
    }

    public function setFechaFinal(\DateTime $fecha_final): static
    {
        $this->fecha_final = $fecha_final;

        return $this;
    }

    public function isEstado(): ?bool
    {
        return $this->estado;
    }

    public function setEstado(?bool $estado): static
    {
        $this->estado = $estado;

        return $this;
    }

    public function getTipo(): ?Tipo
    {
        return $this->tipo;
    }

    public function setTipo(?Tipo $tipo): static
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * @return Collection<int, Admin>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(Admin $user): static
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
        }

        return $this;
    }

    public function removeUser(Admin $user): static
    {
        $this->user->removeElement($user);

        return $this;
    }
}
