<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EvenementRepository;
use App\Repository\UserRepository;
use App\Repository\ParticipationRepository;
use App\Entity\Participation;
use App\Entity\Evenement;

class ParticipationController extends AbstractController
{
    /**
     * @Route("/participation", name="participation")
     */
    public function index(): Response
    {
        return $this->render('participation/index.html.twig', []);
    }

    /**
     * @param EvenementRepository $eventRepo
     * @Route ("/participation", name="participation")
     */
    public function affiche(EvenementRepository $eventRepo)
    {
        $events = $eventRepo->findAll();
        return $this->render('participation/index.html.twig', [
            'events' => $events,
        ]);
    }

    /**
     * @Route ("/event/{id}/details", name="eventdetails")
     */
    public function afficheEvenement(UserRepository $userRepo, ParticipationRepository $participationRepo, EvenementRepository $eventRepo, $id)
    {
        $event = $eventRepo->find($id);
        $username = 'user';
        $user = $userRepo->findOneByUsername($username);

        $participated = false;
        $participation = $participationRepo->findOneByClientAndEvent($user, $event);
        if($participation != null) {
            $participated = true;
        }

        $participations = $event->getParticipations();
        if ($participations != null) {
            $eventParticipant = $participations->count();
        }
        
        $eventFull = false;
        if ($eventParticipant >= $event->getNbparticipant()) {
            $eventFull = true;
        }

        return $this->render('participation/event-details.html.twig', [
            'event' => $event,
            'full' => $eventFull,
            'participated' => $participated
        ]);
    }

    /**
     * @Route ("/event/{id}/participate", name="eventparticipation")
     */
    public function participateEvenement(
        ParticipationRepository $participationRepo,
        EvenementRepository $eventRepo,
        UserRepository $userRepo,
        $id
    ) {
        
        $event = $eventRepo->find($id);
        
        $eventParticipant = 0;
        $participations = $event->getParticipations();
        if ($participations != null) {
            $eventParticipant = $participations->count();
        }

        if ($eventParticipant >= $event->getNbparticipant()) {
            return $this->redirectToRoute('eventdetails', ['id' => $event->getId()]);
        }
        
        $em = $this->getDoctrine()->getManager();
        
        $username = 'user';
        $user = $userRepo->findOneByUsername($username);
        
        if ($user == null) {
            $client = new User();
            $client->setNom($username);
            
            $em->persist($client);
        }

        $participation = new Participation();
        $participation->setEvenement($event);
        $participation->setClient($user);
        
        $event->addParticipation($participation);
        $em->persist($participation);
        $em->persist($event);
        $em->flush();

        return $this->redirectToRoute('eventdetails', ['id' => $event->getId()]);
    }
}
