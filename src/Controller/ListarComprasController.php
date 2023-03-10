<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Repository\CarritoRepository;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Carrito;
use Symfony\Component\Security\Core\Security;


class ListarComprasController extends AbstractController
{
    /**
     * @Route("/listar/compras", name="app_listar_compras")
     */
    public function index(CarritoRepository $carritoRepository, Session $session, Security $security): Response
    {
        if (!$this->isGranted('ROLE_USER')) {  //MA Si no es usuario no podra acceder y será enviado a la página de registro
            return $this->redirectToRoute('app_register'); 
        }
        $carrito = new Carrito();
        $user = $this->getUser();
        $userId = $user->getId();
    if($session->has('carrito')){
     
        $carrito->setUserId((int) $userId);
        $carrito->setListaProd($session->get('carrito'));
        $carritoRepository->add($carrito, true);
        
        $session->remove("carrito");    
    }
    $pedidos = $carritoRepository->findByUserId($userId);
        return $this->render('listar_compras/index.html.twig', [
            'pedidos' => $pedidos,
        ]);
    }    
}
