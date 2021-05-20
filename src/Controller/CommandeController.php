<?php

namespace App\Controller;

use App\Entity\Commande;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use App\Form\CommandeType;
use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
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
    public function affichec(CommandeRepository $repo)
    {
        //$repo=$this->getDoctrine()->getRepository(Produit::class);
        $commande = $repo->findAll();
        return $this->render('commande/index.html.twig', ['commande' => $commande]);
    }
    /**
     * @Route("afficheCd",name="afficheCd")
     */
    public function affiche()
    {
        $cm = $this->getDoctrine()->getManager()->getRepository(Commande::class)->findAll();
         $serializer = new Serializer([new ObjectNormalizer()]);
         $formatted = $serializer->normalize($cm);

         return new JsonResponse($formatted);
        //$commande = $repo->findAll();
        //$json = $SerializerInterface->serialize($commande,'json');
        //return $this->render('commande/index.html.twig', ['commande' => $commande]);
    }

    /**
     * @Route ("suppCo/{refcommande}",name="del")
     */

    public function delete($refcommande, CommandeRepository $repo,SerializerInterface $SerializerInterface)
    {
        $commande = $repo->find($refcommande);
        $em = $this->getDoctrine()->getManager();
        $em->remove($commande);
        $em->flush();
        $json = $SerializerInterface->serialize($commande,'json');

        return $this->redirectToRoute('afficheCommande');
    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("/AddCommande",name="AddCommande")
     */

    public function add(Request $request,SerializerInterface $SerializerInterface)
    {
        $Commande = new Commande();
        $form = $this->createForm(CommandeType::class, $Commande);
        $form->add('Ajouter',SubmitType::class, array( 'attr' => array('class' => 'btn btn-success')));
        $form->handleRequest($request);
        $json = $SerializerInterface->serialize($Commande,'json');
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Commande);
            $em->flush();
            return $this->redirectToRoute('afficheCommande');

        }
        return $this->render('Commande/add.html.twig',[
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("commande/update/{refcommande}",name="updated")
     */
    public function update(CommandeRepository $repo,$refcommande,Request $request,SerializerInterface $SerializerInterface)
    {
        $commande = $repo->find($refcommande);
        $form = $this->createForm(CommandeType::class, $commande);
        $form->add('updated', SubmitType::class);
        $form->handleRequest($request);
        $json = $SerializerInterface->deserialize($commande, Commande::class,'json');
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
    public function recherche(CommandeRepository $repo,Request $request,SerializerInterface $SerializerInterface){
        $data=$request->get('searchcmd');
        $commande=$repo->findBy(['refcommande'=>$data]);
        $json = $SerializerInterface->serialize($commande,'json');
        return $this->render('commande/index.html.twig',
            ['commande'=>$commande]);
    }
    /**
     * @Route ("donne",name="donne")
     */

    public function indexaction(Request $request)
    {
        $snappy = $this->get("knp_snappy.pdf");
        $html = "<h1>hrloo<h1>";
        $filename = "downloadpdf";
    
        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'content-Disposition' => 'attachement; filename="'.$filename.'.pdf"'
            )
        );
        
    }
    /**
     * @Route("ajouterC",name="ajouterC")
     */
    public function ajouterCommande(Request $request)
    {
        $Commande = new Commande();
        $refer = $request->query->get("refcommande");
        $etat = $request->query->get("etat");
        $em = $this->getDoctrine()->getManager();
        $date = new \DateTime('now');

        $Commande->setetat($etat);
        $Commande->setrefcommande($refer);
        $Commande->setDatecommande($date);
        

        $em->persist($Commande);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Commande);
        return new JsonResponse($formatted);

    }
     /**
      * @Route("/deleteCommande", name="deleteCommande")
      */

      public function deleteCommande(Request $request) {
        $id = $request->get("refcommande");

        $em = $this->getDoctrine()->getManager();
        $commande = $em->getRepository(Commande::class)->find($id);
        if($commande!=null ) {
            $em->remove($commande);
            $em->flush();

            $serialize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serialize->normalize("Commande a ete supprimee avec success.");
            return new JsonResponse($formatted);

        }
        return new JsonResponse("id Commande invalide.");


    }
     /**
     * @Route("/updateCommande", name="updateCommande")
     */
    public function editUser(Request $request) {
        $refcommande = $request->get("refcommande");
        $etat = $request->query->get("etat");
       
        $em=$this->getDoctrine()->getManager();
        $commande = $em->getRepository(Commande::class)->find($refcommande);


        $commande->setrefcommande($refcommande);
        $commande->setEtat($etat);
    


        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commande);
            $em->flush();

            return new JsonResponse("success",200);//200 ya3ni http result ta3 server OK
        }catch (\Exception $ex) {
            return new Response("fail ".$ex->getMessage());
        }

    }
    /**
      * @Route("/rechercheCM", name="rechercheCM")
      */

     public function rechercheCM(Request $request)
     {
         $id = $request->get("refcommande");

         $em = $this->getDoctrine()->getManager();
         $commande = $this->getDoctrine()->getManager()->getRepository(Commande::class)->find($id);
         $encoder = new JsonEncoder();
         $normalizer = new ObjectNormalizer();
         $normalizer->setCircularReferenceHandler(function ($etat) {
             return $etat->getEtat();
         });
         $serializer = new Serializer([$normalizer], [$encoder]);
         $formatted = $serializer->normalize($commande);
         return new JsonResponse($formatted);
     }

    
}
