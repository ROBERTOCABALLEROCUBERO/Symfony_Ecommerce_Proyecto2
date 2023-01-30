<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CarritoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class DevolverController extends AbstractController
{
    /**
     * @Route("/devolver", name="app_devolver")
     */
    public function index(Request $request, CarritoRepository $repositorio): Response
    {
        $id = $request->get("pedido_id");
        $carrito = $repositorio->find($id);

        if (!$carrito) {
            throw new NotFoundHttpException();
        }
    
        $repositorio->remove($carrito, true);
    
        return $this->redirectToRoute('app_listar_compras');
    }
}
