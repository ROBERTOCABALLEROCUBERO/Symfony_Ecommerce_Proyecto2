<?php

namespace App\Controller;

use App\Entity\Carrito;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class CarritoController extends AbstractController
{
    /**
     * @Route("/carrito", name="app_carrito")
     */
    public function index(): Response
    {
        return $this->render('carrito/index.html.twig', [
            'controller_name' => 'CarritoController',
        ]);
    }
        /**
     * @Route("/agregar-al-carrito/{id}", name="agregar_al_carrito")
     */
    public function agregarAlCarrito($id, Request $request, Carrito $carrito, Session $session)
    {
        // Obtener el producto mediante el id proporcionado
        $producto = $this->getDoctrine()->getRepository(Productos::class)->find($id);
        // Obtener la cantidad del producto desde el formulario
        $cantidad = $request->request->get('cantidad');
        // Crear una instancia de la entidad "Carrito" con la información del producto y la cantidad
        
        $carrito->setProductoId($producto->getId());
        $carrito->setNombreProducto($producto->getNombreProd());
        $carrito->setCantidad($cantidad);
        // Añadir el objeto "Carrito" a la sesión del usuario
        $session->start();
        $session->set('carrito', $carrito);
        // Redirigir al usuario a la página de visualización del carrito
        return $this->redirectToRoute('ver_carrito');
    }

}
