<?php

namespace App\Controller;
use Symfony\Component\Security\Core\Security;

use App\Entity\Produit;
use App\Entity\Rating;
use App\Entity\User;
use App\Repository\ProduitRepository;
use App\Repository\RatingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

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
    public function affichep(ProduitRepository $repo,RatingRepository $ratings,$id)
    {
        $clientCin = $this->getUser()->getCin();
        $rate = $ratings->findBy(array('idclient' => $clientCin,'idproduit'=>$id));
        if($rate != []){
            $rate = $rate[0]->getRate();
        }
        else{
            $rate=0;
        }
        $produit=$repo->find($id);
        $rates = $ratings->findBy(array('idproduit'=>$id));
        $rates_number = count($rates);
        $average=0;
        
        foreach($rates as $r){
            
            $average+=$r->getRate();
        }
        $average= $average / $rates_number;
       //dd($produit);
        return $this->render('produit_controller_front/produit.html.twig', [
            'produit' => $produit,'average'=>$average,'total'=>$rates_number,'user_rate'=>$rate
        ]);
    }
    
/**
   * @Route("/produitClient/prod/rate/{id}/{rating}", name="rate_produit")
   * @param $id
   * @return mixed
   */

   public function rateProduct(ProduitRepository $repo,RatingRepository $ratings,$id,$rating){
    
    $produit = $repo->find($id);
    $entityManager = $this->getDoctrine()->getManager();
    $clientCin = $this->getUser()->getCin();
    $rate = $ratings->findBy(array('idclient' => $clientCin,'idproduit'=>$id));
    
    if($rate == []){
        $rate = new Rating();
        $rate->setIdclient($clientCin);
        $rate->setIdproduit($id);
        $rate->setRate((int)$rating);
        
    }else{
        $rate = $rate[0];
        $rate->setRate((int)$rating);
    }
    $entityManager->persist($rate);
    $entityManager->flush();
    $rates = $ratings->findBy(array('idproduit'=>$id));
    $rates_number = count($rates);
    $average=0;
    
    foreach($rates as $r){
        
        $average+=$r->getRate();
    }
    $average= $average / $rates_number;
    //$average = $average / $rates_number;
    return new JsonResponse(
        array('average'=>$average,'total'=>$rates_number),
        JsonResponse::HTTP_OK
    );

   }
}

