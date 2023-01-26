<?php

namespace App\Controller;

use App\Entity\Productos;
use App\Form\ProductosType;
use App\Repository\ProductosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Carrito;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("/productos")
 */
class ProductosController extends AbstractController
{
     /**
     * @Route("/", name="app_homepage", methods={"GET"})
     */
    public function homepage(ProductosRepository $productosRepository)
    {
        // your code here
        $ofertaProductos = $productosRepository->findByOnSale();
        $ofertaProductosChunked = array_chunk($ofertaProductos, 8);

        return $this->render('homepage.html.twig', [
            'ofertaProductosChunked' => $ofertaProductosChunked
        ]);
       
    }
    /**
     * @Route("/", name="app_productos_index", methods={"GET"})
     */
    public function index(ProductosRepository $productosRepository): Response
    {
       
        return $this->render('productos/index.html.twig', [
            'productos' => $productosRepository->findAll(),
        ]);
    }
   

    /**
     * @Route("/new", name="app_productos_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ProductosRepository $productosRepository, EntityManager $em): Response
    {
        $producto = new Productos($em);
        $form = $this->createForm(ProductosType::class, $producto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productosRepository->add($producto, true);

            return $this->redirectToRoute('app_productos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('productos/new.html.twig', [
            'producto' => $producto,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_productos_show", methods={"GET"})
     */
    public function show(Productos $producto): Response
    {

       

        return $this->render('productos/show.html.twig', [
            'producto' => $producto,
            
        ]);

    }

    /**
     * @Route("/{id}/edit", name="app_productos_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Productos $producto, ProductosRepository $productosRepository): Response
    {
        $form = $this->createForm(ProductosType::class, $producto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productosRepository->add($producto, true);

            return $this->redirectToRoute('app_productos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('productos/edit.html.twig', [
            'producto' => $producto,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_productos_delete", methods={"POST"})
     */
    public function delete(Request $request, Productos $producto, ProductosRepository $productosRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$producto->getId(), $request->request->get('_token'))) {
            $productosRepository->remove($producto, true);
        }

        return $this->redirectToRoute('app_productos_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
 * @Route("/agregarcarrito/{id}")
 */
public function agregarAlCarrito(Request $request, Session $session, ProductosRepository $productosRepository)
{
    // Obtener el producto mediante el id proporcionado
    $producto = $productosRepository->findOneBy($request->query->get("id"));
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
    return $this->redirectToRoute('app_agregarcarrito');
}



}
