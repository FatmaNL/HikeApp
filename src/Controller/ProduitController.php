<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produit", name="produit")
     */
    public function index(): Response
    {
        return $this->render('produit/afficheProduit.html.twig', [
            'controller_name' => 'ProduitController',
        ]);
    }
    /**
     * @param ProduitRepository $repo
     * @return Response
     * @Route("/afficheProduit",name="afficheProduit")
     */
    public function affiche(ProduitRepository $repo){
        //$repo=$this->getDoctrine()->getRepository(Produit::class);
        $produit=$repo->findAll();
        return $this->render('produit/afficheProduit.html.twig',['produit1'=>$produit]);
    }

    /**
     * @Route ("supppro/{id}",name="d")
     */

    public function delete($id, ProduitRepository $repo){
        $produit=$repo->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($produit);
        $em->flush();

        return $this->redirectToRoute('afficheProduit');
    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("produit/addproduit",name="addproduit")
     */

    public function add(Request $request){
        $produit=new Produit();
        $form=$this->createForm(ProduitType::class,$produit);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();
            return $this->redirectToRoute('afficheProduit');
        }
        return $this->render('produit/addProduite.html.twig',[
            'form'=>$form->createView()
        ]);

    }

    /**
     * @Route("produit/update/{id}",name="update")
     */
    public function update(ProduitRepository $repo,$id,Request $request){
        $produit=$repo->find($id);
        $form=$this->createForm(ProduitType::class,$produit);
        $form->add('update',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('afficheProduit');
        }
        return $this->render('produit/updateProduit.html.twig',[
            'f'=>$form->createView()
        ]);
    }


    /**
     * @Route("produit/recherche",name="recherche")
     */
    public function recherche(ProduitRepository $repo,Request $request){
        $data=$request->get('search');
        $produit=$repo->findBy(['nomproduit'=>$data]);
        return $this->render('produit/index.html.twig',
            ['produit'=>$produit]);
    }

}
