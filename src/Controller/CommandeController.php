<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    /**
     * @Route("/commande", name="commande")
     */
    public function index(): Response
    {
        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController',
        ]);
    }

    /**
     * @param CommandeRepositoryRepository $repo
     * @return Response
     * @Route("afficheCommande",name="afficheCommande")
     */
    public function affiche(CommandeRepository $repo)
    {
        //$repo=$this->getDoctrine()->getRepository(Produit::class);
        $commande = $repo->findAll();
        return $this->render('commande/index.html.twig', ['commande' => $commande]);
    }

    /**
     * @Route ("suppCo/{id}",name="d")
     */

    public function delete($id, CommandeRepository $repo)
    {
        $commande = $repo->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($commande);
        $em->flush();

        return $this->redirectToRoute('afficheCommande');
    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("Commande/AddCommande",name="AddCommande")
     */

    public function add(Request $request)
    {
        $Commande = new Commande();
        $form = $this->createForm(CommandeType::class, $Commande);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Commande);
            $em->flush();
            return $this->redirectToRoute('afficheCommande');

        }
        return $this->render('Commande/add.html.twig',[
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("commande/update/{id}",name="update")
     */
    public function update(CommandeRepository $repo,$id,Request $request)
    {
        $commande = $repo->find($id);
        $form = $this->createForm(CommandeType::class, $commande);
        $form->add('update', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('afficheCommande');
        }
        return $this->render('commande/update.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("commande/recherche",name="recherche")
     */
    public function recherche(CommandeRepository $repo,Request $request){
        $data=$request->get('search');
        $commande=$repo->findBy(['RefCommande'=>$data]);
        return $this->render('commande/index.html.twig',
            ['commande'=>$commande]);
    }

}
