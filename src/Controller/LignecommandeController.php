<?php

namespace App\Controller;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class LignecommandeController extends AbstractController
{
   /**
     * @Route("/panier", name="cart_index")
     */
    public function index(SessionInterface $session, ProduitRepository $ProduitRepository)
    {
        $panier = $session->get('panier' ,[]);
        $panierWithData = [];
        foreach ($panier as $numproduit => $quantite){
            $panierWithData[] = [
            'produit' => $ProduitRepository->find($numproduit),
            'quantite'=> $quantite
            ];
        }
        $total = 0;
        foreach ($panierWithData as $item) {
            
          

            $totalItem= $item['produit']->getPrix() * $item['quantite'];
            $total += $totalItem;
        }
        return $this->render('lignecommande/index.html.twig', [
            'items' => $panierWithData,
            'total' =>$total
        ]);
        
    }
   /**
     * @Route("/panier/add/{numproduit}", name="cart_add")
     */
    public function add($numproduit , SessionInterface $session)    {

        $panier=$session->get('panier',[]);
        if(!empty($panier[$numproduit])){
            $panier[$numproduit]++;
        }else {
            $panier[$numproduit]=1;
        }
        

        $session->set('panier', $panier);

       return $this->redirectToRoute('cart_index');

       
    }
    
        /**
         * @Route("/panier/remove/{id}", name="cart_remove")
         */
        public function remove($id, SessionInterface $session){
            $panier = $session->get('panier', []);
            if(!empty($panier[$id])){
                unset($panier[$id]);
            }
            $session->set('panier', $panier);
            return $this->redirectToRoute('cart_index');

        }
   
}
