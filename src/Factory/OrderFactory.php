<?php

namespace App\Factory;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Productos;

/**
 * Class OrderFactory
 * @package App\Factory
 */
class OrderFactory
{
    /**
     * Creates an order.
     *
     * @return Order
     */
    public function create(): Order
    {
        $order = new Order();
        $order
            ->setEstatus(Order::ESTATUS_CART)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());

        return $order;
    }

    /**
     * Creates an item for a product.
     *
     * @param Productos $product
     *
     * @return OrderItem
     */
    public function createItem(Productos $product): OrderItem
    {
        $item = new OrderItem();
        $item->setNombreProducto($product);
        $item->setCantidad(1);

        return $item;
    }
}