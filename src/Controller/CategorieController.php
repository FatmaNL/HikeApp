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

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="categorie")
     */
    public function index(): Response
    {
        return $this->render('categorie/afficheCategorie.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }

    /**
     * @param CategorieRepository $repo
     * @param Request $request
     * @return Response
     * @Route ("/Categorie",name="categorie")
     */
    public function affiche(CategorieRepository $repo,Request $request){
        if($request->query->get('rech')){
            $data=$request->get('rech');
            $categorie=$repo->findBy(['nomcategorie'=>$data]);
        }else{
            $categorie=$repo->findAll();
        }
        return $this->render('categorie/afficheCategorie.html.twig',['categorie'=>$categorie]);
    }

    /**
     * @param $id
     * @param CategorieRepository $repo
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route ("/categorie/supp/{id}",name="suppcat")
     */
    public function delete($id,CategorieRepository $repo, ProduitRepository $products){
        $prods=$products->findBy(['cat'=>$id]);
        $category = $repo->find($id);
        $em=$this->getDoctrine()->getManager();
        foreach($prods as $prod){
            
            $em->remove($prod);
            $em->flush();
    
        }
        $em->remove($category);
        $em->flush();

        return $this->redirectToRoute('categorie');
        
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("/Categorie/addcat",name="addcat")
     */
    public function add(Request $request){
        $categorie=new Categorie();
        $form=$this->createFormBuilder($categorie)
            ->add('NomCategorie',TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('ajouter', SubmitType::class, array( 'attr' => array('class' => 'btn btn-theme')))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $categorie=$form->getData();
            $em=$this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute('categorie');
        }
        return $this->render('categorie/addCategorie.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @param CategorieRepository $repo
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("/categorie/updcat/{id}",name="updcat")
     */
    public function update(CategorieRepository $repo,$id,Request $request){
        $categorie=$repo->find($id);
        $form=$this->createFormBuilder($categorie)
            ->add('NomCategorie',TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('Modifier', SubmitType::class, array( 'attr' => array('class' => 'btn btn-theme')))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $categorie=$form->getData();
            $em=$this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute('categorie');
        }
        return $this->render('categorie/updateCategorie.html.twig',[
            'f'=>$form->createView(),'id'=>$id
        ]);
    }

}
