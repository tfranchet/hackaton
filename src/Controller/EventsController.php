<?php

namespace App\Controller;

use App\Service\RestService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/events")
 */
class EventsController extends AbstractController
{
    /**
     * @Route("/", name="all_events")
     */
    public function index(Request $request, RestService $rest): Response
    {
        $events = $rest->requestRestApi('events', 'GET');
        return $this->render('events/all.html.twig', [
            'events' => $events,
        ]);
    }

    /**
     * @Route("/new", name="event_new")
     */
    public function new(Request $request, EntityManagerInterface $em, RestService $rest): Response
    {
        $artists = $rest->requestRestApi('artistes', 'GET');
        $salles = $rest->requestRestApi('concert_hall', 'GET');
        $form = $this->createFormBuilder()
            ->add('artistes', ChoiceType::class, ['choices' => $artists, 'multiple' => true])
            ->add('salle', ChoiceType::class, ['choices' => $salles])
            ->add('edition', TextType::class)
            ->add('date', DateType::class)
            ->add('creer', SubmitType::class)
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $rest->requestRestApi('events', 'POST', $form->getData());
            return $this->redirectToRoute('all_events');
        }
        return $this->render('events/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/edit/{id}", name="artiste_edit")
     */
    public function edit($id, Request $request, EntityManagerInterface $em, RestService $rest): Response
    {
        $artists = $rest->requestRestApi('artistes', 'GET');
        $salles = $rest->requestRestApi('concert_hall', 'GET');
        $event = $rest->requestRestApi('events/'. $id, 'GET');
        $form = $this->createFormBuilder()
            ->add('artistes', ChoiceType::class, ['choices' => $artists, 'multiple' => true])
            ->add('salle', ChoiceType::class, ['choices' => $salles])
            ->add('edition', TextType::class)
            ->add('date', DateType::class)
            ->add('creer', SubmitType::class)
            ->getForm();
        $form->get('artistes')->setData($event['artists']);
        $form->get('salle')->setData($event['concert_hall']);
        $form->get('edition')->setData($event['edition']);
        $form->get('date')->setData($event['date']);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $rest->requestRestApi('events/'. $id, 'PUT', $form->getData());
            return $this->redirectToRoute('all_events');
        }
        return $this->render('events/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
