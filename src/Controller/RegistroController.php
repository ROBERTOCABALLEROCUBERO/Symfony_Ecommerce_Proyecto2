<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
Use App\Repository\UsuariosRepository;
use Symfony\Component\HttpFoundation\Request;

class RegistroController extends AbstractController
{
    /**
     * @Route("/registro", name="app_registro1")
     */

    public function index(): Response
    {
        
        return $this->render('registro/index.html.twig');
    }

    /**
     * @Route("/registrocompletado, name="app_registro2")
     */

    public function registro(UsuariosRepository $userRepository,Request $request): Response
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
        
        return $this->render('usuarios/index.html.twig');
    }



}