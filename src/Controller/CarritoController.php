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
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Security\Core\Security;

class CarritoController extends AbstractController
{
    private $em;
    /**
     * @Route("/carrito", name="app_carrito")
     */
    

   
    public function index(Session $session, Request $request, ProductosRepository $productosRepository, Security $security): Response
    {
         // Obtener el producto mediante el id proporcionado
         if (!$security->isGranted('IS_AUTHENTICATED_FULLY')) {
            // Si el usuario no ha iniciado sesión, redirigirlo a la página de inicio de sesión
            return $this->redirectToRoute('app_login');
        }
       
         $id = $request->get("id");
         if (!$id) {
            // Redirigir al usuario a la página principal o mostrar un mensaje de error
            return $this->redirectToRoute('app_homepage');
        }
         $producto = $productosRepository->findOneByid($id); 
         // Obtener la cantidad del producto desde el formulario
         $cantidad = $request->request->get('cantidad');
         // Crear una instancia de la entidad "Carrito" con la información del producto y la cantidad
         $carrito = array(
             'id' => $producto->getId(),
             'nombreProducto' => $producto->getNombreProd(),
             'cantidad' => $cantidad,
             'precio' => $producto->getprecio()
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
         $total = 0;
         $carrito = $session->get('carrito');
         foreach ($carrito as $item) {
             $total += $item['precio'];
         }
        
        
        return $this->render('carrito/index.html.twig', [
            'carrito' => $session->get('carrito'),
            'precio' => $total,
        ]);
    }
    }

        




