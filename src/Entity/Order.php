<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
  /**
     * @ORM\Column(type="string", length=255)
     */
    private $status = self::STATUS_CART;

    /**
     * An order that is in progress, not placed yet.
     *
     * @var string
     */
    const STATUS_CART = 'cart';


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=orderItem::class, mappedBy="orderRef", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $items;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $estatus;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, orderItem>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(orderItem $item): self
    {
        foreach ($this->getItems() as $existingItem) {
            // The item already exists, update the quantity
            if ($existingItem->equals($item)) {
                $existingItem->setCantidad(
                    $existingItem->getCantidad() + $item->getCantidad()
                );
                return $this;
            }
        }
    
        $this->items[] = $item;
        $item->setOrderRef($this);
    
        return $this;
    }

    public function removeItem(orderItem $item): self
    {
        foreach ($this->getItems() as $item) {
            $this->removeItem($item);
        }
    
        return $this;
    }

    public function getEstatus(): ?string
    {
        return $this->estatus;
    }

    public function setEstatus(string $estatus): self
    {
        $this->estatus = $estatus;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    /**
 * Calculates the order total.
 *
 * @return float
 */
public function getTotal(): float
{
    $total = 0;

    foreach ($this->getItems() as $item) {
        $total += $item->getTotal();
    }

    return $total;
}
}
