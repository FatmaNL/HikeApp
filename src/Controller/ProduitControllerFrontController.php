<?php

namespace App\Controller;
use Symfony\Component\Security\Core\Security;

use App\Entity\Produit;
use App\Entity\User;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitControllerFrontController extends AbstractController
{
    /**
     * @Route("/produit", name="produit_controller_front")
     */
    public function index(ProduitRepository $repo)
    {
        $produit=$repo->findAll();
        return $this->render('base2.html.twig', [
            'produit' => $produit
        ]);
    }

    /**
     * @Route("/produitClient", name="afficheProduitFront")
     */
    public function affiche(ProduitRepository $repo)
    {
        $produit=$repo->findAll();
        return $this->render('produit_controller_front/affiche.html.twig', [
            'produit' => $produit
        ]);
    }

    /**
     * @Route("/produitClient/prod/{id}", name="produit")
     */
    public function affichep(ProduitRepository $repo,$id)
    {
        $produit=$repo->find($id);
       // dd($produit);
        return $this->render('produit_controller_front/produit.html.twig', [
            'produit' => $produit
        ]);
    }
    
}
