<?php

namespace App\Controller;

use App\Repository\ArtisteRepository;
use Doctrine\ORM\EntityManager;
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
    public function index(Request $request, ArtisteRepository $artisteRepository): Response
    {
        $artistes = $artisteRepository->findAll();
        return $this->render('templates/artistes/all.html.twig', [
            'artistes' => $artistes,
        ]);
    }

    /**
     * @Route("/id", name="artiste_id")
     */
    public function artiste_id(Request $request): Response
    {
        $method = $request->getMethod();
        switch ($method){
            case 'GET' : $this->redirectToRoute();
        }
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ArtisteController.php',
        ]);
    }
}
