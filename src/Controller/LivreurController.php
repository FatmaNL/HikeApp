<?php

namespace App\Controller;

use App\Entity\Livreur;
use App\Form\LivreurType;
use App\Repository\LivreurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/livreur")
 */
class LivreurController extends AbstractController
{
    /**
     * @Route("/", name="livreur_index", methods={"GET"})
     */
    public function index(LivreurRepository $livreurRepository): Response
    {
        return $this->render('livreur/index.html.twig', [
            'livreurs' => $livreurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/searchlivreur",name="search_livreur")
     */
    public function recherche(LivreurRepository $repo,Request $request){
        
        $data=$request->get('search');
        $livreur=$repo->findBy(['id'=>$data]);
        if($data == "") {
            return $this->redirectToRoute('livreur_index');
        }
        else {
        return $this->render('livreur/index.html.twig',
            ['livreurs'=>$livreur]);
        }    
    }

    /**
     * @Route("/new", name="livreur_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $livreur = new Livreur();
        $form = $this->createForm(LivreurType::class, $livreur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($livreur);
            $entityManager->flush();

            return $this->redirectToRoute('livreur_index');
        }

        return $this->render('livreur/new.html.twig', [
            'livreur' => $livreur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="livreur_show", methods={"GET"})
     */
    public function show(Livreur $livreur): Response
    {
        return $this->render('livreur/show.html.twig', [
            'livreur' => $livreur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="livreur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Livreur $livreur): Response
    {
        $form = $this->createForm(LivreurType::class, $livreur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('livreur_index');
        }

        return $this->render('livreur/edit.html.twig', [
            'livreur' => $livreur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="livreur_delete", methods={"POST"})
     */
    public function delete(Request $request, Livreur $livreur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$livreur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($livreur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('livreur_index');
    }
}
