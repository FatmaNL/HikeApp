<?php

namespace App\Controller;

use App\Form\UserEditType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/profil", name="profil_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        return $this->render('user/profil.html.twig');
    }


    /**
     * @Route("/update",name="update")
     */
    public function update(Request $request){
        $user= $this->getUser();
        $form=$this->createForm(UserEditType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('message', 'User Profil updated with success');

            return $this->redirectToRoute('profil_user');
        }
        return $this->render('user/editprofil.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/password",name="password")
     */
    public function changepassword(Request $request, UserPasswordEncoderInterface $encoder){
        
        if($request->isMethod('POST')) {
            $em=$this->getDoctrine()->getManager();
            $user = $this->getUser();
            
            if($request->request->get('pass') ==  $request->request->get('pass2')) {
                $user->setPassword($encoder->encodePassword($user, $request->get('pass')));
                $em->flush();
                $this->addFlash('message', 'Password changed with success');
                
                return $this->redirectToRoute('profil_user');
            }
            else {
                $this->addFlash('error','Passwords are not identical');
            }
        }

        return $this->render('user/passwordprofil.html.twig');
    }


    /**
     * @Route("/calendar", name="calendar")
     */
    public function indexcalendar(): Response
    {
        return $this->render('calendar/index.html.twig', [
            'controller_name' => 'CalendarController',
        ]);
    }
}
