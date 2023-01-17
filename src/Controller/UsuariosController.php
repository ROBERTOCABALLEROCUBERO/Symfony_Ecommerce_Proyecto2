<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsuariosController extends AbstractController
{
    /**
     * @Route("/usuarios", name="app_usuarios")
     */
    public function index(): Response
    {
        return $this->render('usuarios/index.html.twig', [
            'controller_name' => 'UsuariosController',
        ]);
    }

    /**
     * @Route("/usuarios/registro", name="app_usuarios_registro")
     */
    public function registro(): Response
    {
        
        return $this->render('usuarios/registro/index.html.twig', [
            'controller_name' => 'UsuariosController',
        ]);
    }


}
