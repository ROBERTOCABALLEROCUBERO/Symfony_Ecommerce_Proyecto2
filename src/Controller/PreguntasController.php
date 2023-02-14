<?php

namespace App\Controller;

use App\Entity\Productos;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Preguntas;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\ProductosRepository;

class PreguntasController extends AbstractController
{
    /**
     * @Route("/preguntas", name="app_preguntas")
     */

public function index(Request $request, ProductosRepository $productosRepository): Response
    {
        $id = $request->get("id");
        $texto = $request->get('pregunta');
        $productos = $productosRepository->findOneByid($id);
        $pregunta = new Preguntas();
    $pregunta->setFecha(new \DateTime());
    $pregunta->setUsuarioId($this->getUser());
    $pregunta->setProductosId($productos);
    $pregunta->setTexto($texto);

    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($pregunta);
    $entityManager->flush();

    $data = [
        'pregunta' => $pregunta->getTexto(),
        'fecha' => $pregunta->getFecha()->format('d/m/Y'),
        'usuario' => $pregunta->getUsuarioId()->getUserIdentifier(),
    ];
    return $this->redirectToRoute('app_productos_show', ['id' => $productos->getId(),  'respuesta' => new JsonResponse($data)]);

    }
}
