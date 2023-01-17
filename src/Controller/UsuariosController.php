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
    public function registro(UsuariosRepository $userRepository, Request $request): Response
    {
        $nombre = $request->query->get('nombre');
        $apellido = $request->query->get('Apellido');
        $email = $request->query->get('email');
        $contrasena = $request->query->get('contrasena');
        $fecha = $request->query->get('fecha');
        $tarjeta = $request->query->get('tarjeta');
        $titular = $request->query->get('titular');
        $seguridad = $request->query->get('Seguridad');
        $facturacion = $request->query->get('facturacion');

        $userRepository->registro($nombre , $apellido, $email, $contrasena, $fecha, $tarjeta, $titular, $seguridad, $facturacion);
        return $this->render('usuarios/registro/index.html.twig', [
            'controller_name' => 'UsuariosController',
        ]);
    }


}
