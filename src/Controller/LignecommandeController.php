<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class LignecommandeController extends AbstractController
{
    /**
     * @Route("/Panier", name="Cart")
     */
    public function index(): Response
    {
        return $this->render('lignecommande/index.html.twig', [
            'controller_name' => 'LignecommandeController',
        ]);
    }
    /**
    * @Route("/panier/add/{numproduit}", name="cart_add")
    */
    public function add($numproduit, Request $request)    {
        $session = $request->getSession();
        $panier=$session->get('panier',[]);
        $panier[$numproduit]=1;
        $session->set('panier', $panier);
        dd($session->get('panier'));
    }
}
