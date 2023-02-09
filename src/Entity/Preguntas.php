<?php

namespace App\Entity;

use App\Repository\PreguntasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PreguntasRepository::class)
 */
class Preguntas
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
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="preguntas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuario_id;

    /**
     * @ORM\ManyToOne(targetEntity=Productos::class, inversedBy="preguntas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productos_id;

    /**
     * @ORM\OneToMany(targetEntity=Respuestas::class, mappedBy="Preguntas_id")
     */
    private $respuestas;

    public function __construct()
    {
        $this->respuestas = new ArrayCollection();
    }

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

    public function getUsuarioId(): ?User
    {
        return $this->usuario_id;
    }

    public function setUsuarioId(?User $usuario_id): self
    {
        $this->usuario_id = $usuario_id;

        return $this;
    }

    public function getProductosId(): ?Productos
    {
        return $this->productos_id;
    }

    public function setProductosId(?Productos $productos_id): self
    {
        $this->productos_id = $productos_id;

        return $this;
    }

    /**
     * @return Collection<int, Respuestas>
     */
    public function getRespuestas(): Collection
    {
        return $this->respuestas;
    }

    public function addRespuesta(Respuestas $respuesta): self
    {
        if (!$this->respuestas->contains($respuesta)) {
            $this->respuestas[] = $respuesta;
            $respuesta->setPreguntasId($this);
        }

        return $this;
    }

    public function removeRespuesta(Respuestas $respuesta): self
    {
        if ($this->respuestas->removeElement($respuesta)) {
            // set the owning side to null (unless already changed)
            if ($respuesta->getPreguntasId() === $this) {
                $respuesta->setPreguntasId(null);
            }
        }

        return $this;
    }
}
