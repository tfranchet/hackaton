<?php

namespace App\Controller;

use App\Service\RestService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/notif")
 */
class NotifController extends AbstractController
{

    /**
     * @Route("/new", name="notif_new")
     */
    public function new(Request $request, RestService $rest): Response
    {
        $form = $this->createFormBuilder()
            ->add('texte', TextareaType::class)
            ->add('creer', SubmitType::class)
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $rest->requestRestApi('notifications', 'POST', $form->getData());
            return $this->redirectToRoute('dashboard');
        }
        return $this->render('notification/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
