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
        $editions = $rest->requestRestApi('editions', 'GET');
        $edition = $editions[count($editions)-1];
        $artistes = $rest->requestRestApi('artists', 'GET');
        $events = $rest->requestRestApi('editions/' . $edition['id'] . '/events', 'GET');
        $salles = $rest->requestRestApi('concerthalls', 'GET');
        foreach ($events as $key => $event){
            $events[$key]['artist_id'] = $artistes[$event['artist_id']]['name'];
            $events[$key]['concert_hall_id'] = $salles[$event['concert_hall_id']]['name'];
        }
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
