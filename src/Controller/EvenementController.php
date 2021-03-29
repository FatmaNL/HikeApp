<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use App\Repository\SentierRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
            'evenement' => $evenement
        ]);
    }

    /**
     * @param EvenementRepository $event
     * @return Response
     * Route("evenement",name="evenement")
     */
    public function affiche(EvenementRepository $event) : Response
    {
        $evenement = $event->findAll();
        return $this->render('evenement/index.html.twig', ['evenement' => $evenement]);
    }

    /**
     * @param SentierRepository $sentier
     * @param Request $req
     * @return Response
     * @Route ("evenement/addevent",name="addevent")
     */
    public function add(Request $req, SentierRepository $sent): Response
    {
        $sentier = $sent->findAll();
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
        return $this->render('evenement/add.html.twig', 
        [ 
            'sentier' => $sentier,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("deleteevent/{id}",name="delete")
     */

    public function delete($id, EvenementRepository $repo){
        $evenement=$repo->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($evenement);
        $em->flush();

        return $this->redirectToRoute('evenement');
    }

    /**
     * @Route("evenement/update/{id}",name="updateevent")
     */
    public function update(EvenementRepository $event,$id,Request $req){
        $evenement=$event->find($id);
        $form=$this->createForm(EvenementType::class,$evenement);
        $form->add('Modifier',SubmitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('evenement');
        }
        return $this->render('evenement/update.html.twig',[
            'formupdate'=>$form->createView()
        ]);
    }

    /**
     * @Route("evenement/search",name="search")
     */
    public function recherche(EvenementRepository $repo,Request $req){
        $data=$req->get('search');
        $evenement=$repo->findBy(['nomevenement'=>$data]);
        return $this->render('evenement/index.html.twig',
            ['evenement'=>$evenement]);
    }


}
