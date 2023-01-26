<?php

namespace App\Entity;

use App\Repository\CarritoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CarritoRepository::class)
 */
class Carrito
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
    private $nombre_producto;

    /**
     * @ORM\Column(type="integer")
     */
    private $user_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $cantidad;

    /**
     * @ORM\Column(type="array")
     */
    private $lista_prod = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreProducto(): ?string
    {
        return $this->nombre_producto;
    }

    public function setNombreProducto(string $nombre_producto): self
    {
        $this->nombre_producto = $nombre_producto;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): self
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getListaProd(): ?array
    {
        return $this->lista_prod;
    }

    public function setListaProd(array $lista_prod): self
    {
        $this->lista_prod = $lista_prod;

        return $this;
    }
}
