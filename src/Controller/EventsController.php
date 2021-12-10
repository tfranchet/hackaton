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
use Symfony\Component\Validator\Constraints\Choice;

/**
 * @Route("/events")
 */
class EventsController extends AbstractController
{


    /**
     * @Route("/new", name="event_new")
     */
    public function new(Request $request, EntityManagerInterface $em, RestService $rest): Response
    {

        $artists = $rest->requestRestApi('artists', 'GET');
        $tabartists = [];
        foreach ($artists as $artist){
            $tabartists[$artist['name']] = $artist['id'];
        }
        $salles = $rest->requestRestApi('concerthalls', 'GET');
        $tabsalles = [];
        foreach ($salles as $salle){
            $tabsalles[$salle['name']] = $salle['id'];
        }
        $editions = $rest->requestRestApi('editions', 'GET');
        $tabedition = [];
        foreach ($editions as $edition){
            $tabedition[$edition['name'] . ' ( ' . $edition['year'] . ' )'] = $edition['id'];
        }
        $form = $this->createFormBuilder()
            ->add('artist_id', ChoiceType::class, ['choices' => $tabartists])
            ->add('concert_hall_id', ChoiceType::class, ['choices' => $tabsalles])
            ->add('date', TextType::class)
            ->add('creer', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $querytab = [];
            $querytab['artist_id'] = $form->get('artist_id')->getData();
            $querytab['concert_hall_id'] = $form->get('concert_hall_id')->getData();
            $querytab['date'] = date('c',strtotime($form->get('date')->getData()));
            $querytab['timestamp'] = date('c',strtotime($form->get('date')->getData()));
            $querytab['edition_id'] = $editions[count($editions)-1]['id'];
            $rest->requestRestApi('events', 'POST', json_encode($querytab));
            return $this->redirectToRoute('all_events');
        }
        return $this->render('events/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/edit/{id}", name="event_edit")
     */
    public function edit($id, Request $request, EntityManagerInterface $em, RestService $rest): Response
    {
        $artists = $rest->requestRestApi('artists', 'GET');
        $tabartists = [];
        foreach ($artists as $artist){
            $tabartists[$artist['name']] = $artist['id'];
        }
        $salles = $rest->requestRestApi('concerthalls', 'GET');
        $tabsalles = [];
        foreach ($salles as $salle){
            $tabsalles[$salle['name']] = $salle['id'];
        }
        $event = $rest->requestRestApi('events/'. $id, 'GET');
        $editions = $rest->requestRestApi('editions', 'GET');
        $tabedition = [];
        foreach ($editions as $edition){
            $tabedition[$edition['name'] . ' ( ' . $edition['year'] . ' )'] = $edition['id'];
        }
        $form = $this->createFormBuilder()
            ->add('artist_id', ChoiceType::class, ['choices' => $tabartists])
            ->add('concert_hall_id', ChoiceType::class, ['choices' => $tabsalles])
            ->add('date', TextType::class)
            ->add('creer', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        $form->get('artistes')->setData($event['artist_id']);
        $form->get('salle')->setData($event['concert_hall_id']);
        $form->get('date')->setData($event['date']);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $querytab = [];
            $querytab['artist_id'] = $form->get('artist_id')->getData();
            $querytab['concert_hall_id'] = $form->get('concert_hall_id')->getData();
            $querytab['date'] = date('c',strtotime($form->get('date')->getData()));
            $querytab['timestamp'] = date('c',strtotime($form->get('date')->getData()));
            $querytab['edition_id'] = $event['edition_id'];
            $rest->requestRestApi('events/'. $id, 'PUT', $querytab);
            return $this->redirectToRoute('all_events');
        }
        return $this->render('events/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="all_events")
     */
    public function index( Request $request, RestService $rest, $id = null): Response
    {
        $editions = $rest->requestRestApi('editions', 'GET');
        $artistes = $rest->requestRestApi('artists', 'GET');
        $salles = $rest->requestRestApi('concerthalls', 'GET');
        if($id == null){
            $edition = $editions[count($editions)-1];
        } else {
            $edition = $editions[$id];
        }
        $events = $rest->requestRestApi('editions/'. $edition['id'] . '/events', 'GET');

        foreach ($events as $key => $event){
            $events[$key]['artist_id'] = $artistes[$event['artist_id']]['name'];
            $events[$key]['concert_hall_id'] = $salles[$event['concert_hall_id']]['name'];
        }
        $editions = $rest->requestRestApi('editions', 'GET');
        $tabedition = [];
        foreach ($editions as $edition){
            $tabedition[$edition['name'] . ' ( ' . $edition['year'] . ' )'] = $edition['id'];
        }

        $form = $this->createFormBuilder()
            ->add('edition', ChoiceType::class, ['choices' => $tabedition])
            ->add('rechercher', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            return $this->redirectToRoute('all_events', [
                'id' => $form->get('edition')->getData()
            ]);
        }
        return $this->render('events/all.html.twig', [
            'events' => $events,
            'form' => $form->createView()
        ]);
    }
}
