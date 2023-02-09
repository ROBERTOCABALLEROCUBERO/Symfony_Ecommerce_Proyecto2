<?php

namespace App\Controller;

use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;
use App\Entity\Productos;
use App\Form\ProductosType;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Repository\ProductosRepository;
use App\Service\FileUploader;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AdminController extends AbstractController
{
  
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(Request $request, ProductosRepository $productosRepository, FileUploader $fileUploader): Response
    {
        $productos = $productosRepository->findAll();
    
        foreach ($productos as $producto) {
            if ($request->isMethod('post') && $request->request->get('productoId') == $producto->getId()) {
                $imageFile = $request->files->get('imageFile');
    
                $errors = $this->validator->validate($imageFile, [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image file (jpeg, png)',
                    ])
                ]);
    
                if (count($errors) == 0 && $imageFile) {
                    $imageFileName = $fileUploader->upload($imageFile);
                    $producto->setfotoprod($imageFileName);
    
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($producto);
                    $entityManager->flush();
    
                    return $this->redirectToRoute('app_admin');
                } else {
                    $this->addFlash('error', 'Please upload a valid image file (jpeg, png)');
                }
            }
        }
    
        return $this->render('admin/index.html.twig', [
            'productos' => $productos,
        ]);
    }
    



}
