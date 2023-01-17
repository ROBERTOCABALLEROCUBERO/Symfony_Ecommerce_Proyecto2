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
    public function registro(UsuariosRepository $productosRepository, Request $request): Response
    {
        $nombre = $request->query->get('nombre');
        $apellido = $request->query->get('apellido');
        $nombre = $request->query->get('nombre');
        $nombre = $request->query->get('nombre');
        $nombre = $request->query->get('nombre');
        $nombre = $request->query->get('nombre');
        $nombre = $request->query->get('nombre');
        $nombre = $request->query->get('nombre');
        $nombre = $request->query->get('nombre');
        return $this->render('usuarios/registro/index.html.twig', [
            'controller_name' => 'UsuariosController',
        ]);
    }


}
