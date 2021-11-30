<?php

namespace App\Controller;

use App\Service\RestService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/artiste")
 */
class ArtisteController extends AbstractController
{
    /**
     * @Route("/", name="all_artistes")
     */
    public function index(Request $request, RestService $rest): Response
    {
        $artistes = $rest->requestRestApi('artistes', 'GET');
        return $this->render('artistes/all.html.twig', [
            'artistes' => $artistes,
        ]);
    }

    /**
     * @Route("/new", name="artiste_new")
     */
    public function new(Request $request, EntityManagerInterface $em, RestService $rest): Response
    {
        $form = $this->createFormBuilder()
            ->add('nom', TextType::class)
            ->add('spotify_url', TextType::class)
            ->add('deezer_url', TextType::class)
            ->add('ville', TextType::class)
            ->add('creer', SubmitType::class)
        ->getForm();
        if($form->isSubmitted() && $form->isValid()){
            $rest->requestRestApi('artistes', 'POST', $form->getData());
            return $this->redirectToRoute('all_artistes');
        }
        return $this->render('artistes/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/edit/{id}", name="artiste_edit")
     */
    public function edit($id, Request $request, EntityManagerInterface $em, RestService $rest): Response
    {
        $artiste = $rest->requestRestApi('artistes/'. $id, 'GET');
        $form = $this->createFormBuilder()
            ->add('nom', TextType::class)
            ->add('spotify', TextType::class)
            ->add('deezer', TextType::class)
            ->add('ville', TextType::class)
            ->getForm();
        $form->get('nom')->setData($artiste['name']);
        $form->get('spotify')->setData($artiste['spotify_url']);
        $form->get('deezer')->setData($artiste['deezer_url']);
        $formatedCities = '';
        foreach ($artiste['city'] as $city){
            $formatedCities .= $city['name'] . ', ';
        }
        $form->get('ville')->setData($formatedCities);
        if($form->isSubmitted() && $form->isValid()){
            $rest->requestRestApi('artistes/'. $id, 'PUT', $form->getData());
            return $this->redirectToRoute('all_artistes');
        }
        return $this->render('artistes/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
