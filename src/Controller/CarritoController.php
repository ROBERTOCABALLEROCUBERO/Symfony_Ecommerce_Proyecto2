<?php

namespace App\Controller;

use App\Entity\Carrito;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProductosRepository;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManagerInterface;

class CarritoController extends AbstractController
{
    private $em;
    /**
     * @Route("/carrito", name="app_carrito")
     */
    

   
    public function index(Session $session, Request $request, ProductosRepository $productosRepository): Response
    {
         // Obtener el producto mediante el id proporcionado
         $id = $request->get("id");
         $producto = $productosRepository->findOneByid($id); 
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
        
        return $this->render('carrito/index.html.twig', [
            'carrito' => $carritoSession,
        ]);
    }

        

}
