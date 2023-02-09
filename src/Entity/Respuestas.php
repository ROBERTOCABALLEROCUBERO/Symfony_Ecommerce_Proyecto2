<?php

namespace App\Entity;

use App\Repository\RespuestasRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RespuestasRepository::class)
 */
class Respuestas
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $texto;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity=Preguntas::class, inversedBy="respuestas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Preguntas_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTexto(): ?string
    {
        return $this->texto;
    }

    public function setTexto(string $texto): self
    {
        $this->texto = $texto;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getPreguntasId(): ?Preguntas
    {
        return $this->Preguntas_id;
    }

    public function setPreguntasId(?Preguntas $Preguntas_id): self
    {
        $this->Preguntas_id = $Preguntas_id;

        return $this;
    }
}
