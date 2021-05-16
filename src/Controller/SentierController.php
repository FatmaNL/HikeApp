<?php

namespace App\Controller;

use App\Entity\Sentier;
use App\Form\SentierType;
use App\Repository\SentierRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SentierController extends AbstractController
{
    /**
     * @param SentierRepository $sentier
     * @Route("/sentier", name="sentier")
     */
    public function index(SentierRepository $sentier): Response
    {
        $sentier = $sentier->findAll();
        return $this->render('sentier/affichersentier.html.twig', [
            'controller_name' => 'SentierController',
            'sentier' => $sentier
        ]);
    }

    /**
     * @param SentierRepository $sentier
     * @return Response
     * @Route("/sentier",name="afficher", methods={"GET"})
     */

    public function affiche(SentierRepository $sent)
    {
        $sentier = $sent->findAll();
        return $this->render('sentier/affichersentier.html.twig', ['sentier' => $sentier]);
    }

    //GET json

    /**
     * @Route("/listesentier" , name="listesentier")
     */
    public function getSentiers(SentierRepository $sent, SerializerInterface $serializerInterface){
        $sentiers= $sent->findAll();
        $json=$serializerInterface->serialize($sentiers, 'json', ['groups'=>'sentgroup']);
        dump($json);
        die;
    }

    /**
     * @param Request $req
     * @return Response
     * @Route ("sentier/addsentier",name="addsentier")
     */

    public function add(Request $req)
    {
        $sentier = new Sentier();
        $form = $this->createForm(SentierType::class, $sentier);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sentier);
            $em->flush();
            return $this->redirectToRoute('sentier');
        }
        return $this->render('sentier/addsentier.html.twig', [
            'formsentier' => $form->createView()
        ]);

    }

    //POST api

    /**
     * @Route ("/api/addsentier", name="api_addsentier")
     */
    public function addSentier(Request $req, SerializerInterface $serializerInterface, ValidatorInterface $validator){
        $content=$req->getContent();
        try{
            $sentier=$serializerInterface->deserialize($content, Sentier::class,'json');
            $errors= $validator->validate($sentier);
            if (count($errors) > 0) {
                return $this->json($errors,400);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($sentier);
            $em->flush();
            return $this->json($sentier, 201, [], ['groups'=>'sentgroup']);
        } catch (NotEncodableValueException $e){
            return $this->json([
                'status'=> 400,
                'message'=> $e->getMessage()
            ], 400);
        }
    }

    /**
     * @Route ("deletesentier/{id}",name="deletesentier")
     */

    public function delete($id, SentierRepository $repo){
        $sentier=$repo->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($sentier);
        $em->flush();

        return $this->redirectToRoute('sentier');
    }

    /**
     * @Route("sentier/update/{id}",name="updatesentier")
     */
    public function update(SentierRepository $sent,$id,Request $req){
        $sentier=$sent->find($id);
        $form=$this->createForm(SentierType::class,$sentier);
        $form->add('Modifier',SubmitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('sentier');
        }
        return $this->render('sentier/updatesentier.html.twig',[
            'formupdate'=>$form->createView()
        ]);
    }

    /**
     * @Route("sentier/search",name="searchsentier")
     */
    public function recherche(SentierRepository $repo,Request $req){
        $data=$req->get('searchsentier');
        $sentier=$repo->findBy(['nomsentier'=>$data]);
        return $this->render('sentier/affichersentier.html.twig',
            ['sentier'=>$sentier]);
    }


}
