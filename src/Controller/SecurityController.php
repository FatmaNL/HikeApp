<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{   

    /**
     * @Route("/", name="home")
     */
    public function home() {
        return $this->render('FrontOffice/index.html.twig');
        
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function registration(Request $request, UserPasswordEncoderInterface $encoder) {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user ->setPassword($hash);
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("user/signup", name="app_registerr")
     */
    public function  signupAction(Request  $request, UserPasswordEncoderInterface $passwordEncoder) {

        $email = $request->query->get("email");
        $password = $request->query->get("password");
        $nom = $request->query->get("nom");
        $prenom = $request->query->get("prenom");
        $cin = $request->query->get("cin");
        $age = $request->query->get("age");
        $sexe = $request->query->get("sexe");
        $adresse = $request->query->get("adresse");
        $tel = $request->query->get("tel");
        
        
        

        //control al email 
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return new Response("email invalid.");
        }
        $user = new User();
        $user->setNom($nom);
        $user->setPrenom($prenom);
        $user->setCin($cin);
        $user->setAge($age);
        $user->setSexe($sexe);
        $user->setAdresse($adresse);
        $user->setTel($tel);
        $user->setEmail($email);
        $pass = $passwordEncoder->encodePassword(
            $user,
            $password
        );
        $user->setPassword($pass);
       


        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

                return new JsonResponse("success",200);//200 ya3ni http result ta3 server OK
        }catch (\Exception $ex) {
            return new Response("execption ".$ex->getMessage());
        }
    }



    /**
     * @Route("user/signin", name="app_loginn")
     */

    public function signinAction(Request $request) {
        $email = $request->query->get("email");
        $password = $request->query->get("password");

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(['email'=>$email]);//
        if($user){
            //lazm n9arn password zeda madamo crypté nesta3mlo password_verify
            if(password_verify($password,$user->getPassword())) {
                $serializer = new Serializer([new ObjectNormalizer()]);
                $formatted = $serializer->normalize($user);
                return new JsonResponse($formatted);
            }
            else {
                return new Response("passowrd not found");
            }
        }
        else {
            return new Response("failed");

        }
    }

    /**
     * @Route("user/edituser", name="app_gestion_profile")
     */

    public function editUser(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
        $cin = $request->get("cin");
        $email = $request->query->get("email");
        $nom = $request->query->get("nom");
        $prenom = $request->query->get("prenom");
        $age = $request->query->get("age");
        $adresse = $request->query->get("adresse");
        $em=$this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($cin);
        

        $user->setNom($nom);
        $user->setPrenom($prenom);
        $user->setAge($age);
        $user->setAdresse($adresse);
        $user->setEmail($email);



        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return new JsonResponse("success",200);//200 ya3ni http result ta3 server OK
        }catch (\Exception $ex) {
            return new Response("fail ".$ex->getMessage());
        }

    }




    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
             return $this->redirectToRoute('home');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
