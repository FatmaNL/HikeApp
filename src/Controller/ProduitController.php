<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\User;
use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ProduitController extends AbstractController
{

    /**
     * @param ProduitRepository $repo
     * @return Response
     * @Route("/Produit",name="afficheProduit")
     */
    public function affiche(ProduitRepository $repo, Request $request)
    {
        if ($this->getUser()->getRoles()['0'] == 'ROLE_USER' || $this->getUser()->getRoles()['0'] == 'ROLE_ADMIN') {
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


    /* affiche with JSON */

    /**
     * @param ProduitRepository $repo
     * @return Response
     * @Route("/Produitjson",name="afficheProduitjson")
     */
    public function affichejson(ProduitRepository $repo, Request $request)
    {
        
        if ($request->query->get('search')) {
            $data = $request->get('search');
            $produit = $repo->findBy(['nomproduit' => $data]);
        } else {
            $produit = $repo->findAll();
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($produit);
            return new JsonResponse($formatted);
        }
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

    /* add with json */

    /**
     * @Route ("/produit/addproduitjson",name="addproduitjson")
     */
    public function addjson(Request $request, CategorieRepository $repo)
    {
        //$categorie = $repo->findAll();
        $produit = new Produit();
        $nomproduit = $request->query->get("nomproduit");
        $quantite = $request->query->get("quantite");
        $prix = $request->query->get("prix");
        $image = $request->query->get("image");
        /*$idcat = $request->query->get("cat");
        $nomcat = $request->query->get("cat_name");

        $cats = array();
        foreach ($categorie as $cat) {
            array_push($cats, $cat->nomcategorie);
        }*/
       
           /* $file = $form->get('image')->getData();
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
            }*/

           /* $categoryID = $repo->findAll();
            $produit->cat=$categoryID[0]->idcat;
            $produit->catName=$categoryID[0]->nomcat;*/
            $em = $this->getDoctrine()->getManager();
            $produit->setNomproduit($nomproduit);
            $produit->setQuantite($quantite);
            $produit->setPrix($prix);
            $produit->setImage($image);
           /* $produit->setImage($newFilename);*/
            $em->persist($produit);
            $em->flush();
 
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($produit);
        return new JsonResponse($formatted);
    }

    /**
     * @Route("/produit/update/{id}",name="update")
     */
    public function update(ProduitRepository $repo, $id, Request $request, CategorieRepository $repo2)
    {
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

    /*update with json*/
    
    /**
     * @Route("/produit/updatejson/{id}",name="updatejson")
     */
    public function updatejson(ProduitRepository $repo, $id, Request $request, CategorieRepository $repo2)
    {
        //$categorie = $repo2->findAll();
        $produit = $repo->find($id);
        $em = $this->getDoctrine()->getManager();
        $produit->setNomproduit($request->get("nomproduit"));
        $produit->setQuantite($request->get("quantite"));
        $produit->setPrix($request->get("prix"));
        /*$cats = array();
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
            $produit->cat = $categoryID;*/
           
            //$produit->setImage($newFilename);
            $em->persist($produit);
            $em->flush();
            

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($produit);
        return new JsonResponse("produit a ete modifie avec success");
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

    /*suppression with json*/

    /**
     * @param $id
     * @param ProduitRepository $repo
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route ("/produit/suppprojson/{id}",name="d")
     */
    public function deletejson($id, ProduitRepository $repo)
    {
        $produit = $repo->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($produit);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize("produit a été supprimer avec success.");
        return new JsonResponse($formatted);
    }
}
