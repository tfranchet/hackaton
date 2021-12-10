<?php

namespace App\Controller;

use App\Service\RestService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Choice;

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
        $artistes = $rest->requestRestApi('artists', 'GET');
        return $this->render('artistes/all.html.twig', [
            'artistes' => $artistes,
        ]);
    }

    /**
     * @Route("/new", name="artiste_new")
     */
    public function new(Request $request, EntityManagerInterface $em, RestService $rest): Response
    {
        $countries = $rest->requestRestApi('countries', 'GET');
        $choicetab = [];
        foreach ($countries as $country){
            $choicetab[$country['name']] = $country['id'];
        }
        $form = $this->createFormBuilder()
            ->add('name', TextType::class)
            ->add('spotify_url', TextType::class)
            ->add('deezer_url', TextType::class)
            ->add('countries', ChoiceType::class, ['choices' => $choicetab])
            ->add('creer', SubmitType::class)
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $querytab = [];
            $querytab['name'] = $form->get('name')->getData();
            $querytab['spotify_url'] = $form->get('spotify_url')->getData();
            $querytab['deezer_url'] = $form->get('deezer_url')->getData();
            $querytab['countries'] = [$countries[$form->get('countries')->getData() -1]
            ];
            $rest->requestRestApi('artists', 'POST', json_encode($querytab));
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
        $artiste = $rest->requestRestApi('artists/'. $id, 'GET');
        $countries = $rest->requestRestApi('countries', 'GET');
        $choicetab = [];
        foreach ($countries as $country){
            $choicetab[$country['name']] = $country['id'];
        }
        $form = $this->createFormBuilder()
            ->add('name', TextType::class)
            ->add('spotify_url', TextType::class)
            ->add('deezer_url', TextType::class)
            ->add('countries', ChoiceType::class, ['choices' => $choicetab])
            ->add('sauvegarder', SubmitType::class)
            ->getForm();
        $form->get('name')->setData($artiste['name']);
        $form->get('spotify_url')->setData($artiste['spotify_url']);
        $form->get('deezer_url')->setData($artiste['deezer_url']);
        $form->get('countries')->setData($artiste['countries'][0]['id']);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $rest->requestRestApi('artistes/'. $id, 'PUT', $form->getData());
            return $this->redirectToRoute('all_artistes');
        }
        return $this->render('artistes/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
