<?php

namespace App\Controller;

use App\Entity\Artiste;
use App\Form\ArtisteType;
use App\Repository\ArtisteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $repo = $entityManager->getRepository(Artiste::class);
        $artistes = $repo->findAll();
        return $this->render('artistes/all.html.twig', [
            'artistes' => $artistes,
        ]);
    }

    /**
     * @Route("/new", name="artiste_new")
     */
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $artiste = new Artiste();
        $form = $this->createForm(ArtisteType::class, $artiste);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($artiste);
            $em->flush();
            return $this->redirectToRoute('all_artistes');
        }
        return $this->render('artistes/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/edit/{id}", name="artiste_edit")
     */
    public function edit(string $id, Request $request , EntityManagerInterface $em): Response
    {
        $artiste = $em->getRepository(Artiste::class)->find($id);
        $form = $this->createForm(ArtisteType::class, $artiste);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($artiste);
            $em->flush();
            return $this->redirectToRoute('all_artistes');
        }
        return $this->render('artistes/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="artiste_show")
     */
    public function show(string $id, EntityManagerInterface $em): Response
    {
        $artiste = $em->getRepository(Artiste::class)->find($id);
        return $this->render('artistes/one.html.twig', [
            'artiste' => $artiste,
        ]);
    }


}
