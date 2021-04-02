<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class CommandeController extends AbstractController
{
    /**
     * @Route("/commande", name="commande")
     */
    public function index(): Response
    {
        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController',
        ]);
    }

    /**
     * @param CommandeRepositoryRepository $repo
     * @return Response
     * @Route("afficheCommande",name="afficheCommande")
     */
    public function affiche(CommandeRepository $repo)
    {
        //$repo=$this->getDoctrine()->getRepository(Produit::class);
        $commande = $repo->findAll();
        return $this->render('commande/index.html.twig', ['commande' => $commande]);
    }

    /**
     * @Route ("suppCo/{refcommande}",name="del")
     */

    public function delete($refcommande, CommandeRepository $repo)
    {
        $commande = $repo->find($refcommande);
        $em = $this->getDoctrine()->getManager();
        $em->remove($commande);
        $em->flush();

        return $this->redirectToRoute('afficheCommande');
    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("/AddCommande",name="AddCommande")
     */

    public function add(Request $request ,ProduitRepository $produitRepository)
    {
        $produit = $produitRepository->findAll();
        $prod=array();
        foreach ($produit as $produits) {
            array_push($prod, $produits->nomproduit);
        }
       
        $Commande = new Commande();
        $form = $this->createForm(CommandeType::class, $Commande);
        $form->add('Ajouter',SubmitType::class, array( 'attr' => array('class' => 'btn btn-success')));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $prodid= $produitRepository->findOneBy(['nomproduit'=>$Commande->produits])->numproduit;
        
            $em = $this->getDoctrine()->getManager();
            $em->persist($Commande);
            $em->flush();
            return $this->redirectToRoute('afficheCommande');

        }
        return $this->render('Commande/add.html.twig',[
            'form'=>$form->createView(),
            'produits'=>$prod
        ]);
    }
    /**
     * @Route("commande/update/{refcommande}",name="updated")
     */
    public function update(CommandeRepository $repo,$refcommande,Request $request)
    {
        $commande = $repo->find($refcommande);
        $form = $this->createForm(CommandeType::class, $commande);
        $form->add('updated', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('afficheCommande');
        }
        return $this->render('commande/update.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("commande/recherche",name="rechercher")
     */
    public function recherche(CommandeRepository $repo,Request $request){
        $data=$request->get('searchcmd');
        $commande=$repo->findBy(['refcommande'=>$data]);
        return $this->render('commande/index.html.twig',
            ['commande'=>$commande]);
    }

}
