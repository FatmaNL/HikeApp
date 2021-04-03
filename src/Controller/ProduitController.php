<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\User;
use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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
    public function affiche(ProduitRepository $repo, Request $request)
    {
        if($this->getUser()->getRoles()['0'] == 'ROLE_USER' || $this->getUser()->getRoles()['0'] == 'ROLE_ORGANISATEUR'){
            return $this->redirectToRoute('home');
        }
        if ($request->query->get('search')) {
            $data = $request->get('search');
            $produit = $repo->findBy(['nomproduit' => $data]);
        } else {
            $produit = $repo->findAll();
        }


        return $this->render('produit/afficheProduit.html.twig', ['produit' => $produit]);
    }


    /**
     * @Route ("/produit/addproduit",name="addproduit")
     */

    public function add(Request $request, CategorieRepository $repo)
    {
        $categorie = $repo->findAll();
        $produit = new Produit();
        $cats = array();
        foreach ($categorie as $cat) {
            array_push($cats, $cat->nomcategorie);
        }
        $form = $this->createForm(ProduitType::class, $produit);
        $form->add('ajouter', SubmitType::class, array('attr' => array('class' => 'btn btn-theme')));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('image')->getData();
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $newFilename = $originalFilename . '-' . uniqid() . '.' . $file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    echo $e;
                }
            }

            $categoryID = $repo->findOneBy(['nomcategorie' => $produit->catName])->idcategorie;
            $produit->cat = $categoryID;
            $em = $this->getDoctrine()->getManager();
            $produit->setImage($newFilename);
            $em->persist($produit);
            $em->flush();
            return $this->redirectToRoute('afficheProduit');
        }
        return $this->render('produit/addProduit.html.twig', [
            'form' => $form->createView(),
            'categories' => $cats
        ]);
    }

    /**
     * @Route("/produit/update/{id}",name="update")
     */
    public function update(ProduitRepository $repo, $id, Request $request, CategorieRepository $repo2){
        $categorie = $repo2->findAll();
        $produit = $repo->find($id);
       
        $cats = array();
        foreach ($categorie as $cat) {
            array_push($cats, $cat->nomcategorie);
        }
        
        $form = $this->createForm(ProduitType::class, $produit);
        $form->add('save', SubmitType::class, array('label' => 'Modifier', 'attr' => array('class' => 'btn btn-theme')));
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('image')->getData();
          
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL

                $newFilename = $originalFilename . '-' . uniqid() . '.' . $file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    echo $e;
                }
            }
            $categoryID = $repo2->findOneBy(['nomcategorie' => $produit->catName])->idcategorie;
            $produit->cat = $categoryID;
            $em = $this->getDoctrine()->getManager();
            $produit->setImage($newFilename);
            $em->flush();
            return $this->redirectToRoute('afficheProduit');
        }
        return $this->render('produit/updateProduit.html.twig', [
            'f' => $form->createView(), 'id' => $id, 'categories' => $cats
        ]);
    }

    /**
     * @param $id
     * @param ProduitRepository $repo
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route ("/produit/supppro/{id}",name="d")
     */

    public function delete($id, ProduitRepository $repo)
    {
        $produit = $repo->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($produit);
        $em->flush();


        return $this->redirectToRoute('afficheProduit');
    }
}
