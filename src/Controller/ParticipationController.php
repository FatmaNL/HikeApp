<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EvenementRepository;


class ParticipationController extends AbstractController
{
    /**
     * @Route("/participation", name="participation")
     */
    public function index(): Response
    {
        return $this->render('participation/index.html.twig',[]);
    }
    
    /**
     * @param EvenementRepository $eventRepo
     * @Route ("/participation", name="participation")
     */
    public function affiche(EvenementRepository $eventRepo)
    {
        $events = $eventRepo->findAll();
        return $this->render('participation/index.html.twig',[
            'events' => $events
        ]);
    }
}
