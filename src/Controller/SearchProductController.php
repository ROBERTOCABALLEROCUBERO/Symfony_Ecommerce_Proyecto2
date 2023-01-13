<?php

namespace App\Controller;
use App\Entity\Productos;
use App\Form\ProductosType;
use App\Repository\ProductosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class SearchProductController extends AbstractController
{
    /**
     * @Route("/search/product", name="app_search_product")
     */
    public function index(ProductosRepository $productosRepository, Request $request): Response
{
    $nombre = $request->query->get('nombre');
    $productos = $nombre ? $productosRepository->findByName($nombre) : $productosRepository->findAll();
    return $this->render('search_product/index.html.twig', [
        'productos' => $productos,
    ]);
}
    }

