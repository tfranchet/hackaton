<?php

namespace App\Controller;

use App\Service\RestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/log")
 */
class LogInController extends AbstractController
{
    /**
     * @Route("in", name="login")
     */
    public function index(Request $request, RequestStack $requestStack, RestService $rest): Response
    {
        $form = $this->createFormBuilder()
            ->add('username', TextType::class, ['label' => 'Login'])
            ->add('mdp', PasswordType::class, ['label' => 'Mot de passe'])
            ->add('login', SubmitType::class, ['label' => 'Se connecter'])
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $role = 'yes';
            $requestStack->getSession()->set('role', $role);
            return $this->redirectToRoute('dashboard');
        }
        return $this->render('login/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("out", name="logout")
     */
    public function logout(Request $request, RequestStack $requestStack, RestService $rest): Response
    {
        $requestStack->getSession()->clear();
        return $this->redirectToRoute('dashboard');
    }
}
