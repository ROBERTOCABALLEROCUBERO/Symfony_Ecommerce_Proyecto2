<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Manager\CartManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="app_cart")
     */
    public function index(CartManager $cartManager): Response
    {
        $cart = $cartManager->getCurrentCart();

        $form = $this->createForm(CartType::class, $cart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cart->setUpdatedAt(new \DateTime());
            $cartManager->save($cart);

            return $this->redirectToRoute('cart');
        }

        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
            'form' => $form->createView()
        ]);
    }
}
