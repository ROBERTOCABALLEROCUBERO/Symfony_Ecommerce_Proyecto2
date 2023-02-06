<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
class ContactoController extends AbstractController
{
    /**
     * @Route("/contacto", name="app_contacto")
     */
    public function index(Request $request, MailerInterface $mailer): Response
    {
        if ($request->isMethod('POST')) {
            $email = (new Email())
                ->from($request->request->get('email'))
                ->to('receiver@example.com')
                ->subject('Contact form')
                ->text($request->request->get('message'))
                ->html('<p>' . $request->request->get('message') . '</p>')
            ;

            $mailer->send($email);

            $this->addFlash('success', 'Your message has been sent!');

            return $this->redirectToRoute('app_contacto');
        }

        return $this->render('contacto/index.html.twig', [
            'controller_name' => 'ContactoController',
        ]);
    }
    }

