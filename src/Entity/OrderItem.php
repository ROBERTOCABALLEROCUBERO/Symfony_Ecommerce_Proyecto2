<?php

namespace App\Entity;

use App\Repository\OrderItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=OrderItemRepository::class)
 */
class OrderItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Productos::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $nombre_producto;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(1)
     */
    private $cantidad;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="items")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderRef;




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreProducto(): ?Productos
    {
        return $this->nombre_producto;
    }

    public function setNombreProducto(?Productos $nombre_producto): self
    {
        $this->nombre_producto = $nombre_producto;

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

    public function getOrderRef(): ?Order
    {
        return $this->orderRef;
    }

    public function setOrderRef(?Order $orderRef): self
    {
        $this->orderRef = $orderRef;

        return $this;
    }

    /**
     * Tests if the given item given corresponds to the same order item.
     *
     * @param OrderItem $item
     *
     * @return bool
     */

    public function equals(OrderItem $item): bool
    {
        return $this->getNombreProducto()->getId() === $item->getNombreProducto()->getId();

    }

    public function getTotal(): float
{
    return $this->getNombreProducto()->getPrecio() * $this->getCantidad();
}
}
