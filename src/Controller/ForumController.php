<?php

namespace App\Controller;

use App\Entity\Forum;
use App\Form\ForumType;
use App\Repository\ForumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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


    }


