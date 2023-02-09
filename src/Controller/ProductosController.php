<?php

namespace App\Controller;

use App\Entity\Productos;
use App\Form\Productos1Type;
use App\Repository\ProductosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function new(Request $request, ProductosRepository $productosRepository): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {  //MA 1.6 Si el usuario no es administrador no podra acceder y será enviado a la pagina de login
            return $this->redirectToRoute('app_login');
        }


        $producto = new Productos();
        $form = $this->createForm(Productos1Type::class, $producto);
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
        if (!$this->isGranted('ROLE_ADMIN')) {  //MA 1.6 Si el usuario no es administrador no podrá acceder y será enviado a la principal
            return $this->redirectToRoute('app_login');
        }


        $form = $this->createForm(Productos1Type::class, $producto);
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
        if (!$this->isGranted('ROLE_ADMIN')) {  //MA 1.6 Si el usuario no es administrador no podra acceder y será enviado a la pagina de login 
            return $this->redirectToRoute('app_login');
        }


        if ($this->isCsrfTokenValid('delete' . $producto->getId(), $request->request->get('_token'))) {
            $productosRepository->remove($producto, true);
        }

        return $this->redirectToRoute('app_productos_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/producto/{id}/imagen", name="get_product_image")
     */
    public function getProductImage($id, ProductosRepository $productosRepository)
    {
$producto = $productosRepository->findOneByid($id);
        // Obtener la ruta de la imagen

$ruta = '../public/img/'.$producto->getfotoprod();

        // Verificar si la imagen existe
        if (!file_exists($ruta)) {
            throw $this->createNotFoundException('Image not found');
        }

        // Enviar la imagen al navegador
        $image = file_get_contents($ruta);
        $response = new Response($image);
        $response->headers->set('Content-Type', 'image/png');
        return $response;
    }
}
