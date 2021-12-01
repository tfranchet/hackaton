<?php

namespace App\Controller;

use App\Service\RestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard")
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="dashboard")
     */
    public function index(RequestStack $request, RestService $rest): Response
    {
        $artistes = $rest->requestRestApi('artistes', 'GET');
        $events = $rest->requestRestApi('events', 'GET');
        $notifs = $rest->requestRestApi('notifications', 'GET');
        $role = $request->getSession()->get('role');
        return $this->render('dashboard/index.html.twig', [
            'artistes' => $artistes,
            'events' => $events,
            'notifs' => $notifs,
            'role' => $role,
        ]);
    }
}
