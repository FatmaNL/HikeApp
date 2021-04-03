<?php

namespace App\Controller;

use App\Entity\Transport;
use App\Form\TransportType;
use App\Repository\TransportRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
