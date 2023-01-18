<?php

namespace App\Controller;
Use App\Repository\UsuariosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class UsuariosController extends AbstractController
{
    /**
     * @Route("/usuarios", name=" app_iniciosesion")
     */
    public function index(): Response
    {
        
        return $this->render('usuarios/index.html.twig', [
            'controller_name' => 'UsuariosController',
        ]);
    }

    


}
