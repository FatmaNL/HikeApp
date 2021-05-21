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
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ForumController extends AbstractController
{
    /**
     * @Route("/forum", name="forum")
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
    public
    function recherche(ForumRepository $repo, Request $request)
    {
        $data = $request->get('search');
        $forum = $repo->findBy(['sujet' => $data]);
        return $this->render('forum/afficheForum.twig',
            ['forum1' => $forum]);
    }

    /**
     * @Route("/forum/{id}/{comment}", name="add_comment_forum")
     */

    public function addComment(ForumRepository $repo, ReponseRepository $reponse, SerializerInterface $serializer, $id, $comment)
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
        foreach ($comments as $c) {
            array_push($final_comments, ["description" => $c->getDescription(), "date" => $c->getDate()]);
        }


        $data = $serializer->serialize($final_comments, JsonEncoder::FORMAT);
        return new JsonResponse($data, Response::HTTP_OK, [], true);


    }

    /**
     * @Route("/forum/{id}", name="forum")
     */

    public function afficheforum(ForumRepository $repo, ReponseRepository $reponse, $id)
    {
        $comments = $reponse->findAll();

        $forum = $repo->find($id);

        return $this->render('forum/index.html.twig', [

            'forum' => $forum, 'comments' => $comments]);
    }

    /**
     * @Route("/ajouterForum", name="add_reclamation")
     */

    public function ajouterForum(Request $request)
    {
        $ajouter = new Forum();
        $sujet = $request->query->get("sujet");
        $description = $request->query->get("description");
        $em = $this->getDoctrine()->getManager();
        $date = new \DateTime('now');
        $status = $request->query->get("status");


        $ajouter->setSujet($sujet);
        $ajouter->setDescription($description);
        $ajouter->setStatus($status);

        $em->persist($ajouter);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($ajouter);
        return new JsonResponse($formatted);

    }

    /**
     * @Route("/supprimerForum", name="delete_forum")
     */

    public function supprimerForumAction(Request $request)
    {
        $id = $request->get("id");

        $em = $this->getDoctrine()->getManager();
        $forum = $em->getRepository(Forum::class)->find($id);
        if ($forum != null) {
            $em->remove($forum);
            $em->flush();

            $serialize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serialize->normalize("Forum a ete supprimee avec success.");
            return new JsonResponse($formatted);

        }
        return new JsonResponse("id forum invalide.");


    }

    /**
     * @Route("/displayForum", name="display_forum")
     */
    public function allRecAction()
    {

        $forum = $this->getDoctrine()->getManager()->getRepository(Forum::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($forum);

        return new JsonResponse($formatted);

    }

    /**
     * @Route("/updateForum", name="update_forum")
     */
    public function modifierForum(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $forum = $this->getDoctrine()->getManager()
            ->getRepository(Forum::class)
            ->find($request->get("id"));

        $forum->setSujet($request->get("sujet"));
        $forum->setDescription($request->get("description"));

        $em->persist($forum);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($forum);
        return new JsonResponse("Forum a ete modifiee avec success.");

    }
}




