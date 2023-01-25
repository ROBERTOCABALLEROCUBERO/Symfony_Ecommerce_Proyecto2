<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Entity\Carrito;
use App\Entity\Productos;
use App\Form\ProductosType;
use App\Repository\ProductosRepository;
use Symfony\Component\HttpFoundation\Session\Session;


class AgregarcarritoController extends AbstractController
{
    /**
     * @Route("/agregarcarrito", name="app_agregarcarrito")
     */
   
    public function index(Session $session): Response
    {
 
        $carrito = $session->get('carrito');
        return $this->render('agregarcarrito/index.html.twig', [
            'carrito' => $carrito,
        ]);
    }
}
