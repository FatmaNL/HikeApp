<?php

namespace App\Controller;

use App\Form\EditUserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
 /**
 * @Route("/admin", name="admin_")
 */

class AdminController extends AbstractController
{
    
    /**
     * @Route("",name="interface")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/utilisateur",name="showuser")
     */

    public function userlists(UserRepository $repo) {
        return $this->render("admin/users.html.twig", [
            'users' => $repo ->findAll()
        ]);

    }

    /**
     * @Route("/search",name="search")
     */
    public function recherche(UserRepository $repo,Request $request){
        
        $data=$request->get('search');
        $user=$repo->findBy(['cin'=>$data]);
        if($data == "") {
            return $this->redirectToRoute('admin_showuser');
        }
        else {
        return $this->render('admin/users.html.twig',
            ['users'=>$user]);
        }    
    }

    /**
     * @Route("/update/{cin}",name="update_user")
     */
    public function update(UserRepository $repo,$cin,Request $request, UserPasswordEncoderInterface $encoder){
        $user=$repo->find($cin);
        $form=$this->createForm(EditUserType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('message', 'User updated with success');

            return $this->redirectToRoute('admin_showuser');
        }
        return $this->render('admin/updateuser.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route ("/supprimer/{cin}",name="delete_user")
     */

    public function delete($cin, UserRepository $repo){
        $user=$repo->find($cin);
        $em=$this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        $this->addFlash('message', 'User deleted with success');
        return $this->redirectToRoute('admin_showuser');
    }

    /**
     * @Route("/change_password/{cin}",name="change_password")
     */
    public function change_user_password(UserRepository $repo,$cin,Request $request, UserPasswordEncoderInterface $encoder) {
        $user=$repo->find($cin);
        if($request->isMethod('POST')) {
            
            $em=$this->getDoctrine()->getManager();
        
            if($request->request->get('pass') ==  $request->request->get('pass2')) {
                $user->setPassword($encoder->encodePassword($user, $request->get('pass')));
                $em->flush();
                $this->addFlash('message', 'Password changed with success');
                
                return $this->redirectToRoute('admin_showuser');
            }
            else {
                $this->addFlash('error','Passwords are not identical');
            }
        }


        return $this->render('admin/passworduser.html.twig');
    }
}