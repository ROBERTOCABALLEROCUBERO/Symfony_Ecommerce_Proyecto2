<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class IdiomasController extends AbstractController
{
    /**
     * @Route("/idiomas", name="app_idiomas")
     */
/*     public function changeLanguage($locale, SessionInterface $session) {
        $session -> set('_locale', $locale);

        return new Response('Lenguaje cambiado a ' . $locale);
    } */
} 

//Mario:
//El controlador recibe un parametro $locale que corresponde al idioma seleccionado por el usuario
//Se utiliza la session de symfony para almacenar el idioma seleccionado, devuelve una respuesta indicando el idioma seleccionado
