<?php

namespace App\Controller;

use App\Entity\Forum;
use App\Entity\Reponse;
use App\Form\ForumType;
use App\Repository\ForumRepository;
use App\Repository\ReponseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class ForumController extends AbstractController
{
    /**
     * @Route("/forum", name="forum-index")
     */
    public function index(): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'ForumController',
        ]);
    }

    /**
     * @param ForumRepository $repo
     * @return Response
     * @Route("forum/afficheForum",name="afficheForum")
     */
    public function affiche(ForumRepository $repo)
    {
        //$repo=$this->getDoctrine()->getRepository(Forum::class);

        $forum = $repo->findAll();
        return $this->render('forum/afficheForum.twig', ['forum1' => $forum]);
    }

    /**
     * @Route ("suppforum/{id}",name="effacer")
     */

    public function delete($id, ForumRepository $repo)
    {
        $forum = $repo->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($forum);
        $em->flush();

        return $this->redirectToRoute('afficheForum');
    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("forum/addforum",name="addforum")
     */

    public function add(Request $request)
    {
        $forum = new Forum();
        $form = $this->createForm(ForumType::class, $forum);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $forum->setDate(new \DateTime());
            $forum->setStatus('en cours');
            $em = $this->getDoctrine()->getManager();
            $em->persist($forum);
            $em->flush();
            return $this->redirectToRoute('afficheForum');
        }
        return $this->render('forum/addForum.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("forum/update/{id}",name="mise")
     */

    public function update(ForumRepository $repo, $id, Request $request)
    {
        $forum = $repo->find($id);
        $form = $this->createForm(ForumType::class, $forum);
        $form->add('update', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('afficheForum');
        }
        return $this->render('forum/updateForum.twig', [
            'f' => $form->createView()
        ]);
    }


    /**
     * @Route("forum/recherche",name="search")
     */
    public function recherche(ForumRepository $repo, Request $request)
    {
        $data = $request->get('search');
        $forum = $repo->findBy(['sujet' => $data]);
        return $this->render('forum/afficheForum.twig',
            ['forum1' => $forum]);
    }

    /**
     * @Route("/forum/{id}/{comment}", name="add_comment_forum")
     */

    public function addComment(ForumRepository $repo,ReponseRepository $reponse,SerializerInterface $serializer,$id,$comment)
    {

        $commentaire = new Reponse();
        $commentaire->setDescription($comment);
        $forum = $repo->find($id);
        $forum->setDate(new \DateTime());
        $commentaire->setDate(new \DateTime());
        $commentaire->setForum($forum);
        $em = $this->getDoctrine()->getManager();
        $em->persist($commentaire);
        $em->flush();
        $comments = $reponse->findAll();
        $final_comments = array();
        foreach($comments as $c){
            array_push($final_comments,["description"=>$c->getDescription(), "date"=>$c->getDate()]);
        }


        $data = $serializer->serialize($final_comments, JsonEncoder::FORMAT);
        return new JsonResponse($data, Response::HTTP_OK, [], true);


    }

     /**
     * @Route("/forum/{id}", name="forum")
     */
    public function afficheforum (ForumRepository $repo,ReponseRepository $reponse,$id)
    {
        $comments = $reponse->findAll();

        $forum = $repo->find($id);

        return $this->render('forum/index.html.twig', [

            'forum' => $forum, 'comments'=>$comments]);
    }
}



