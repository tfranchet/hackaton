<?php

namespace App\Controller;

use App\Entity\concert;
use App\Form\concertType;
use App\Repository\concertRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/concert")
 */
class ConcertController extends AbstractController
{
    /**
     * @Route("/", name="all_concerts")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $repo = $entityManager->getRepository(ConcertHall::class);
        $concerts = $repo->findAll();
        return $this->render('concert_hall/all.html.twig', [
            'concerts' => $concerts,
        ]);
    }

    /**
     * @Route("/new", name="concert_new")
     */
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $concert = new ConcertHall();
        $form = $this->createForm(ConcertHallType::class, $concert);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($concert);
            $em->flush();
            return $this->redirectToRoute('all_concerts');
        }
        return $this->render('concert_hall/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/edit/{id}", name="concert_edit")
     */
    public function edit(string $id, Request $request , EntityManagerInterface $em): Response
    {
        $concert = $em->getRepository(ConcertHall::class)->find($id);
        $form = $this->createForm(ConcertType::class, $concert);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($concert);
            $em->flush();
            return $this->redirectToRoute('all_concerts');
        }
        return $this->render('concert_hall/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="concert_show")
     */
    public function show(string $id, EntityManagerInterface $em): Response
    {
        $concert = $em->getRepository(Concert::class)->find($id);
        return $this->render('concert_hall/one.html.twig', [
            'concert' => $concert,
        ]);
    }


}
