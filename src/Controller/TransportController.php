<?php

namespace App\Controller;

use App\Entity\Transport;
use App\Form\TransportType;
use App\Repository\TransportRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
//use Doctrine\ORM\EntityManagerInterface;
//use App\Controller\EntityManagerInterface;

class TransportController extends AbstractController
{
    /**
     * @param TransportRepository $transport
     * @Route("/transport", name="transport")
     */
    public function index(TransportRepository $trans): Response
    {
        $transport = $trans->findAll();
        return $this->render('transport/affichertransport.html.twig', [
            'controller_name' => 'TransportController',
            'transport' => $transport
        ]);
    }

    /**
     * @param TransportRepository $trans
     * @return Response
     * Route("transport",name="transport")
     */

    public function affiche(TransportRepository $trans)
    {
        $transport = $trans->findAll();
        return $this->render('transport/affichertransport.html.twig', ['transport' => $transport]);
    }

    //GET api

    /**
     * @Route("/listetransport" , name="listetransport")
     */
    public function getTransports(TransportRepository $trans, SerializerInterface $serializerInterface){
        $transports= $trans->findAll();
        $json=$serializerInterface->serialize($transports, 'json', ['groups'=>'transgroup']);
        dump($json);
        die;
    }


    /**
     * @param Request $req
     * @return Response
     * @Route ("transport/addtransport",name="addtransport")
     */

    public function add(Request $req)
    {
        $transport = new Transport();
        $form = $this->createForm(TransportType::class, $transport);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($transport);
            $em->flush();
            return $this->redirectToRoute('transport');
        }
        return $this->render('transport/addtransport.html.twig', [
            'formtransport' => $form->createView()
        ]);

    }

    //POST api

    /**
     * @Route ("/api/addtransport", name="api_addtransport")
     */
    public function addTransport(Request $req, SerializerInterface $serializerInterface, ValidatorInterface $validator){
        $content=$req->getContent();
        try{
            $transport=$serializerInterface->deserialize($content, Transport::class,'json');
            $errors= $validator->validate($transport);
            if (count($errors) > 0) {
                return $this->json($errors,400);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($transport);
            $em->flush();
            return $this->json($transport, 201, [], ['groups'=>'transgroup']);            
        } catch (NotEncodableValueException $e){
            return $this->json([
                'status'=> 400,
                'message'=> $e->getMessage()
            ], 400);
        }
    }

    /**
     * @Route ("deletetransport/{id}",name="deletetransport")
     */

    public function delete($id, TransportRepository $repo){
        $transport=$repo->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($transport);
        $em->flush();

        return $this->redirectToRoute('transport');
    }

    //DELETE api

    /**
     * @Route("api/deletetransport/{id}", name="api_deletetransport")
     * @return Response
     */
    public function deleteTransport($id, TransportRepository $repo)
    {
        $transport = $repo->findOneBy(['idtransport' => $id]);
        $em=$this->getDoctrine()->getManager();
        $em->remove($transport);
        $em->flush();

        return new Response("Transport deleted!");
    }

    /**
     * @Route("transport/update/{id}",name="updatetransport")
     */
    public function update(TransportRepository $trans,$id,Request $req){
        $transport=$trans->find($id);
        $form=$this->createForm(TransportType::class,$transport);
        $form->add('Modifier',SubmitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('transport');
        }
        return $this->render('transport/updatetransport.html.twig',[
            'formupdatetr'=>$form->createView()
        ]);
    }

    //PUT api
    /**
     * @Route("api/updatetransport/{id}",name="api_updatetransport")
     * @param Request $req
     */
    public function updateTransport(TransportRepository $repo,$id,Request $req){
        try{
            $transport = $repo->findOneBy(['idtransport' => $id]);
            $data = json_decode($req->getContent(), true);

            empty($data['type']) ? true : $transport->setType($data['type']);
            empty($data['volumemax']) ? true : $transport->setVolumemax($data['volumemax']);
            empty($data['nombre_transports']) ? true : $transport->setNombreTransports($data['nombre_transports']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($transport);
            $em->flush();
            return $this->json($transport, 200, [], ['groups'=>'transgroup']);
        } catch (NotEncodableValueException $e){
            return $this->json([
                'status'=> 400,
                'message'=> $e->getMessage()
            ], 400);
        }
    }

    /**
     * @Route("transport/search",name="searchtransport")
     */
    public function recherche(TransportRepository $repo,Request $req){
        $data=$req->get('searchtransport');
        $transport=$repo->findBy(['volumemax'=>$data]);
        return $this->render('transport/affichertransport.html.twig',
            ['transport'=>$transport]);
    }


}
