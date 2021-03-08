<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EvenementController extends AbstractController
{
    /**
     * @param EvenementRepository $event
     * @Route("/evenement", name="evenement")
     */
    public function index(EvenementRepository $event): Response
    {
        $evenement = $event->findAll();
        return $this->render('evenement/index.html.twig', [
            'controller_name' => 'EvenementController',
            'evenement1' => $evenement
        ]);
    }

    /**
     * @param EvenementRepository $event
     * @return Response
     * Route("/evenement",name="evenement")
     */

    public function affiche(EvenementRepository $event)
    {
        $evenement = $event->findAll();
        return $this->render('evenement/index.html.twig', ['evenement1' => $evenement]);
    }

    /**
     * @param Request $req
     * @return Response
     * @Route ("evenement/addevent",name="addevent")
     */

    public function add(Request $req)
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();
            return $this->redirectToRoute('evenement');
        }
        return $this->render('evenement/add.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route ("suppevent/{id}",name="supp")
     */

    public function delete($id, EvenementRepository $repo){
        $evenement=$repo->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($evenement);
        $em->flush();

        return $this->redirectToRoute('evenement');
    }

}
