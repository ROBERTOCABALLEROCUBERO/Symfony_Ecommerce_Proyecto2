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
use App\Repository\PreguntasRepository;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Serializer;

class PreguntasController extends AbstractController
{
    /**
     * @Route("/preguntas", name="app_preguntas")
     */

    public function index(Request $request, ProductosRepository $productosRepository): Response
    {
        $productos = new Productos();
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
            'usuario' => $pregunta->getUsuarioId()->getNombre(),
        ];

        return new JsonResponse($data);
    }


    /**
     * @Route("/preguntas/borrar/{id}", name="preguntas_borrar", methods={"DELETE"})
     */
    public function borrarPregunta(Request $request, Preguntas $pregunta, PreguntasRepository $preguntasRepository): Response
    {
        $id = $request->get("id");
        $borrar = $preguntasRepository->borrar($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($borrar);
        $entityManager->flush();

        // Retorna una respuesta de éxito
        return new JsonResponse(['success' => true]);
    }
}