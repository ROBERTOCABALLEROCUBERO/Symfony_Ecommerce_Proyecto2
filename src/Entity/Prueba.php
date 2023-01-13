<?php

namespace App\Entity;

use App\Repository\PruebaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PruebaRepository::class)
 */
class Prueba
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $prueba;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrueba(): ?string
    {
        return $this->prueba;
    }

    public function setPrueba(string $prueba): self
    {
        $this->prueba = $prueba;

        return $this;
    }
}
