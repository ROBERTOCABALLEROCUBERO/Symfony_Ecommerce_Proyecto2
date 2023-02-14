<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RespuestasController extends AbstractController
{
    /**
     * @Route("/respuestas", name="app_respuestas")
     */
    public function index(): Response
    {
        return $this->render('respuestas/index.html.twig', [
            'controller_name' => 'RespuestasController',
        ]);
    }
}