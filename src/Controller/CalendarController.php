<?php

namespace App\Controller;

use App\Entity\Calendar;
use App\Form\CalendarType;
use App\Repository\CalendarRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/calendar")
 */
class CalendarController extends AbstractController
{
    /**
     * @Route("/", name="calendar_index", methods={"GET"})
     */
    public function index(CalendarRepository $calendarRepository): Response
    {
        return $this->render('calendar/index.html.twig', [
            'calendars' => $calendarRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="calendar_new")
     * @IsGranted("ROLE_ORGANISATEUR")
     */
    public function new(Request $request): Response
    {
        $calendar = new Calendar();
        $form = $this->createForm(CalendarType::class, $calendar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($calendar);
            $entityManager->flush();

            return $this->redirectToRoute('profil_calendar');
        }

        return $this->render('calendar/new.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/{id}/edit", name="calendar_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ORGANISATEUR")
     */
    public function edit(Request $request, Calendar $calendar): Response
    {
        $form = $this->createForm(CalendarType::class, $calendar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('calendar_index');
        }

        return $this->render('calendar/edit.html.twig', [
            'calendar' => $calendar,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route ("/delete/{id}",name="calendar_delete")
     * @IsGranted("ROLE_ORGANISATEUR")
     */

    public function delete($id, CalendarRepository $repo){
        $calendar=$repo->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($calendar);
        $em->flush();
        $this->addFlash('message', 'Event deleted with success');
        return $this->redirectToRoute('calendar_index');
    }
}
