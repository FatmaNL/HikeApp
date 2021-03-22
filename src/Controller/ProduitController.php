<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Produit;

use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{

    /**
     * @param ProduitRepository $repo
     * @return Response
     * @Route("/Produit",name="afficheProduit")
     */
    public function affiche(ProduitRepository $repo,Request $request){
        if( $request->query->get('search')){
            $data=$request->get('search');
            $produit=$repo->findBy(['nomproduit'=>$data]);
        }
        else{$produit=$repo->findAll();}
        
        return $this->render('produit/afficheProduit.html.twig',['produit'=>$produit]);
    }

    /**
     * @param $id
     * @param ProduitRepository $repo
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route ("/produit/supppro/{id}",name="d")
     */
    
    public function delete($id, ProduitRepository $repo){
        $produit=$repo->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($produit);
        $em->flush();
        

        return $this->redirectToRoute('afficheProduit');
    }

    /**
     * @Route ("/produit/addproduit",name="addproduit")
     */

    public function add(Request $request,CategorieRepository $repo){
        $categorie=$repo->findAll();
        $produit=new Produit();
        $cats=array();
        foreach($categorie as $cat){
            array_push($cats,$cat->nomcategorie);
            
        }
        $form=$this->createFormBuilder($produit)
        ->add('NomProduit',TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('Quantite',TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('Prix',TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('cat',TextType ::class, array('attr' => array('class' => 'form-control',  'placeholder'=>"Category"))) 
        ->add('ajouter', SubmitType::class, array( 'attr' => array('class' => 'btn btn-theme')))
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $produit=$form->getData();
            $categoryID = $repo->findOneBy(['nomcategorie'=>$produit->cat])->idcategorie;
            $produit->catName = $produit->cat;
            $produit->cat = $categoryID;
            $em=$this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush(); 
            return $this->redirectToRoute('afficheProduit');
        }
        return $this->render('produit/addProduit.html.twig',[
            'form'=>$form->createView(),
            'categories'=>$cats
        ]);

    
    }

    /**
     * @Route("/produit/update/{id}",name="update")
     */
    public function update(ProduitRepository $repo,$id,Request $request){
        $produit=$repo->find($id);
        $form=$this->createFormBuilder($produit)
            ->add('NomProduit',TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('Quantite',TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('Prix',TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('cat',TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('save', SubmitType::class, array('label' => 'Modifier', 'attr' => array('class' => 'btn btn-theme')))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('afficheProduit');
        }
        return $this->render('produit/updateProduit.html.twig',[
            'f'=>$form->createView(),'id'=>$id
        ]);
    }

}

