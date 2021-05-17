<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Transport;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use App\Repository\SentierRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EvenementController extends AbstractController
{
    /**
     * @param EvenementRepository $event
     * @Route("/evenement", name="evenement")
     */
    public function index(EvenementRepository $event): Response
    {
        $evenement = $event->findAll();
        return $this->render('evenement/index.html.twig', [
            'controller_name' => 'EvenementController',
            'evenement' => $evenement
        ]);
    }

    /**
     * @param EvenementRepository $event
     * @return Response
     * Route("evenement",name="evenement")
     */
    public function affiche(EvenementRepository $event) : Response
    {
        $evenement = $event->findAll();
        return $this->render('evenement/index.html.twig', ['evenement' => $evenement]);
    }

    //GET json

    /**
     * @Route("/listeevenement" , name="listeevenement")
     */
    public function getEvenements(EvenementRepository $event, SerializerInterface $serializerInterface){
        $evenements= $event->findAll();
        $json=$serializerInterface->serialize($evenements, 'json', ['groups'=>'eventgroup']);
        dump($json);
        die;
    }

    /**
     * @param SentierRepository $sentier
     * @param EvenementRepository $event
     * @param Request $req
     * @return Response
     * @Route ("evenement/addevent",name="addevent")
     */
    public function add(Request $req, SentierRepository $sent, EvenementRepository $event): Response
    {
        $sentier = $sent->findAll();
        $evenementobj = $event->findAll();
        $evenement = new Evenement();
        //$transport = new Transport();
        $eventform = $this->createForm(EvenementType::class, $evenement);
        $eventform->add('Ajouter', SubmitType::class);

        $eventform->handleRequest($req);
        if ($eventform->isSubmitted() && $eventform->isValid()) {
            // $imageFile = $req->get('imageFile');

            // $evenement->setImageFile($imageFile);

            $em = $this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();
            return $this->redirectToRoute('evenement');
        }
        return $this->render('evenement/add.html.twig', 
        [ 
            'form' => $eventform->createView(),
            'evenementList' => $evenementobj
        ]);
    }

    //POST api

    /**
     * @Route ("/api/addevenement", name="api_addevenement")
     */
    public function addEvenement(Request $req, SerializerInterface $serializerInterface, ValidatorInterface $validator){
        $content=$req->getContent();
        try{
        $evenement=$serializerInterface->deserialize($content, Evenement::class,'json');
        $errors= $validator->validate($evenement);
        if (count($errors) > 0) {
            return $this->json($errors,400);
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($evenement);
        $em->flush();
        return $this->json($evenement, 201, [], ['groups'=>'eventgroup']);
        }catch(NotEncodableValueException $e){
            return $this->json([
                'status'=> 400,
                'message'=> $e->getMessage()
            ], 400);
        }
    }

    /**
     * @Route ("deleteevent/{id}",name="delete")
     */

    public function delete($id, EvenementRepository $repo){
        $evenement=$repo->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($evenement);
        $em->flush();

        return $this->redirectToRoute('evenement');
    }

    //DELETE api

    /**
     * @Route("api/deleteevenement/{id}", name="api_deleteevenement")
     * @return Response
     */
    public function deleteEvenement($id, EvenementRepository $repo)
    {
        $evenement = $repo->findOneBy(['id' => $id]);
        $em=$this->getDoctrine()->getManager();
        $em->remove($evenement);
        $em->flush();

        return new Response("Evenement deleted!");
    }

    /**
     * @Route("evenement/update/{id}",name="updateevent")
     */
    public function update(EvenementRepository $event,$id,Request $req){
        $evenement=$event->find($id);
        $form=$this->createForm(EvenementType::class,$evenement);
        $form->add('Modifier',SubmitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('evenement');
        }
        return $this->render('evenement/update.html.twig',[
            'formupdate'=>$form->createView()
        ]);
    }
    
    //PUT api
    /**
     * @Route("api/updateevenement/{id}",name="api_updateevenement")
     * @param Request $req
     */
    public function updateEvenement(EvenementRepository $repo,$id,Request $req){
        try{
            $evenement = $repo->findOneBy(['id' => $id]);
            $data = json_decode($req->getContent(), true);

            empty($data['nomevenement']) ? true : $evenement->setNomevenement($data['nomevenement']);
            empty($data['depart']) ? true : $evenement->setDepart($data['depart']);
            empty($data['destination']) ? true : $evenement->setDestination($data['destination']);
            empty($data['nbparticipant']) ? true : $evenement->setNbparticipant($data['nbparticipant']);
            empty($data['dateevenement']) ? true : $evenement->setDateevenement($data['dateevenement']);
            empty($data['duree']) ? true : $evenement->setDuree($data['duree']);
            empty($data['prix']) ? true : $evenement->setPrix($data['prix']);
            empty($data['programme']) ? true : $evenement->setProgramme($data['programme']);
            empty($data['contact']) ? true : $evenement->setContact($data['contact']);
            empty($data['infos']) ? true : $evenement->setInfos($data['infos']);
            empty($data['type']) ? true : $evenement->setType($data['type']);
            empty($data['circuit']) ? true : $evenement->setCircuit($data['circuit']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();
            return $this->json($evenement, 200, [], ['groups'=>'eventgroup']);
        } catch (NotEncodableValueException $e){
            return $this->json([
                'status'=> 400,
                'message'=> $e->getMessage()
            ], 400);
        }
    }

    /**
     * @Route("evenement/search",name="search")
     */
    public function recherche(EvenementRepository $repo,Request $req){
        $data=$req->get('search');
        $evenement=$repo->findBy(['nomevenement'=>$data]);
        return $this->render('evenement/index.html.twig',
            ['evenement'=>$evenement]);
    }


}
