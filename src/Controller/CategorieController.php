<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Produit;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CategorieController extends AbstractController
{
    
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


    /* display witn json */
    /**
     * @param CategorieRepository $repo
     * @param Request $request
     * @return Response
     * @Route ("/Categoriejson",name="categoriejson")
     */
    public function affichejson(CategorieRepository $repo,Request $request){
        if($request->query->get('rech')){
            $data=$request->get('rech');
            $categorie=$repo->findBy(['nomcategorie'=>$data]);
        }else{
            $categorie=$repo->findAll();
            
        }
        $serializer = new Serializer([new ObjectNormalizer()]);
        
        $formatted = $serializer->normalize($categorie);
        
        return new JsonResponse($formatted);
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

    /* delete with json */

    /**
     * @param $id
     * @param CategorieRepository $repo
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route ("/categorie/suppjson/{id}",name="suppcatjson")
     */
    public function deletejson($id,CategorieRepository $repo, ProduitRepository $products){
        $prods=$products->findBy(['cat'=>$id]);
        $category = $repo->find($id);
        $em=$this->getDoctrine()->getManager();
        foreach($prods as $prod){
            
            $em->remove($prod);
            $em->flush();
    
        }
        $em->remove($category);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize("categorie a été supprimer avec success.");
        return new JsonResponse($formatted);
        
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

    /* add with json */

     /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("/Categorie/addcatjson",name="addcatjson")
     */
    public function addjson(Request $request){
        $categorie=new Categorie();
       
        $nomcategorie = $request->query->get("nomcategorie");
            $em=$this->getDoctrine()->getManager();
            $categorie->setNomcategorie($nomcategorie);
            $em->persist($categorie);
            $em->flush();
   
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($categorie);
        return new JsonResponse($formatted);
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

    /* update with json */

    /**
     * @param CategorieRepository $repo
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("/categorie/updcatjson/{id}",name="updcatjson")
     */
    public function updatejson(CategorieRepository $repo,$id,Request $request){
        $categorie=$repo->find($id);
            $em=$this->getDoctrine()->getManager();
            $categorie->setNomcategorie($request->get("nomcategorie"));
            $em->persist($categorie);
            $em->flush();
           
        
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($categorie);
        return new JsonResponse("produit a ete modifie avec success");
    }
}
