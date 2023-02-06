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
        if (!$this->isGranted('ROLE_USER')) {  //MA Si el usuario no es usuario no podra acceder y será enviado a la register
            return $this->redirectToRoute('app_register'); 
        }
        // Obtener el producto mediante el id proporcionado
        if (!$security->isGranted('IS_AUTHENTICATED_FULLY')) {
            // Si el usuario no ha iniciado sesión, redirigirlo a la página de inicio de sesión
            return $this->redirectToRoute('app_login');
        }

        $id = $request->get("id");
        if (!$id || $productosRepository->findOneMaxID($id) < $id) {
            $session->start();
            $carrito = $session->get('carrito', []);

            $total = 0;
            foreach ($carrito as $item) {
                $total += $item['precio'] * $item['cantidad'];
            }

            return $this->render('carrito/index.html.twig', [
                'carrito' => $carrito,
                'precio' => $total,
            ]);
        }
        $producto = $productosRepository->findOneByid($id);
        // Obtener la cantidad del producto desde el formulario
        $cantidad = $request->request->get('cantidad');
        // Crear una instancia de la entidad "Carrito" con la información del producto y la cantidad
        $carrito = [
            'id' => $producto->getId(),
            'nombreProducto' => $producto->getNombreProd(),
            'cantidad' => $cantidad,
            'precio' => $producto->getPrecio()
        ];
        // Añadir el objeto "Carrito" a la sesión del usuario
        $session->start();
        if ($session->has('carrito')) {
            $carritoSession = $session->get('carrito');
            $existeProducto = false;
            foreach ($carritoSession as &$itemCarrito) {
                if ($itemCarrito['id'] === $carrito['id']) {
                    $itemCarrito['cantidad'] += $carrito['cantidad'];
                    $existeProducto = true;
                    break;
                }
            /* Para cada elemento, se compara su identificador con el identificador del producto actual que se agrega al carrito. 
             Si los identificadores coinciden, significa que el producto actual ya existe en el carrito, por lo que solo se aumenta la cantidad del producto en el carrito. 
             Además, la variable booleana "$existeProducto" se establece en verdadero. Una vez que se encuentra el producto, el ciclo se rompe utilizando "break".*/
            }
            if (!$existeProducto) {
                array_push($carritoSession, $carrito);
            }
            $session->set('carrito', $carritoSession);
        }
        else {
            $session->set('carrito', [$carrito]);
        }
        $total = 0;
        $carrito = $session->get('carrito');
        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }


        return $this->render('carrito/index.html.twig', [
            'carrito' => $session->get('carrito'),
            'precio' => $total,
        ]);
    }

    /**
     * @Route("/limpiar-carrito", name="app_limpiar_carrito")
     */
    public function limpiarCarrito(Session $session)
    {
        // Limpia el carrito
        $session->remove('carrito');

        return $this->redirectToRoute('app_carrito');
    }

    /**
     * @Route("/actualizar-cantidad/{id}/{cantidad}", name="app_actualizar_cantidad")
     */
    public function actualizarCantidadAction(Request $request, $id, $cantidad)
    {
        $id = $request->get("id");
        $cantidad = $request->get("cantidad");
        $op = $request->get("op");
        $session = $request->getSession();

        if ($session->has('carrito')) {
            $carrito = $session->get('carrito');
            foreach ($carrito as &$item) {
                if ($item['id'] == $id) {
                    if ($op == 'add') {
                        $item['cantidad'] += 1;
                    }
                    elseif ($op == 'sub') {
                        if(!$item['cantidad'] == 0){
                        $item['cantidad'] -= 1;
                        }
                    }
                    break;
                }
            }
            $session->set('carrito', $carrito);
        }
        return $this->redirectToRoute('app_carrito');
    }
      /**
     * @Route("/app/eliminar-producto/{id}", name="app_eliminar_producto")
     */
    public function eliminarProducto(Request $request, Session $session)
    {
        $id = $request->get("id");
        // Obtiene el carrito de la sesión
        if ($session->has('carrito')) {
            $carrito = $session->get('carrito');
            foreach ($carrito as $index => $item) {
                if ($item['id'] == $id) {
                    unset($carrito[$index]);
                }
            }
            $session->set('carrito', $carrito);
        }
        // Elimina el producto con el ID especificado
       

        // Guarda el carrito actualizado en la sesión
        $session->set('carrito', $carrito);

        return $this->redirectToRoute('app_carrito');
    }



}
