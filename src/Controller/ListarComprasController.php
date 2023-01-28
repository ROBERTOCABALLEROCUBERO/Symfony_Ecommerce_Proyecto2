<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Repository\CarritoRepository;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Carrito;


class ListarComprasController extends AbstractController
{
    /**
     * @Route("/listar/compras", name="app_listar_compras")
     */
    public function index(CarritoRepository $carritoRepository, Carrito $carrito, Session $session): Response
    {

        $user = $this->getUser();
        $carrito = new Carrito();
        $carrito->setUserId($user->getUserIdentifier());
        $carrito->setListaProd($session->get('carrito'));

        $carritoRepository->add($carrito, true);

$pedidos = $carritoRepository->findByUserId($user->getUserIdentifier());


        return $this->render('listar_compras/index.html.twig', [
            'pedidos' => $pedidos,
        ]);
    }
}
