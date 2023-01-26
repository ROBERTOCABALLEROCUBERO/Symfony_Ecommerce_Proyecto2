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
use Doctrine\ORM\EntityManagerInterface;

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

    public function agregarAlCarrito(Request $request, Session $session, ProductosRepository $productosRepository, EntityManagerInterface $em)
    {
        // Obtener el producto mediante el id proporcionado
        $id = $request->get("id");
        $producto = $this->$em->getRepository(Productos::class)->findOneBy(['id' => $id]);
        // Obtener la cantidad del producto desde el formulario
        $cantidad = $request->request->get('cantidad');
        // Crear una instancia de la entidad "Carrito" con la información del producto y la cantidad
        $carrito = array(
            'id' => $producto->getId(),
            'nombreProducto' => $producto->getNombreProd(),
            'cantidad' => $cantidad
        );
        // Añadir el objeto "Carrito" a la sesión del usuario
        $session->start();
        if($session->has('carrito')){
            $carritoSession = $session->get('carrito');
            array_push($carritoSession, $carrito);
            $session->set('carrito', $carritoSession);
        }else{
            $session->set('carrito', array($carrito));
        }
        // Redirigir al usuario a la página de visualización del carrito
        return $this->redirectToRoute('app_carrito');
    }
}
