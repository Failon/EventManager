<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

# Entities
use AppBundle\Entity\User;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        $success = $request->get('success');

        return $this->render('default/index.html.twig', array('success' => $success));
    }

    /**
     * @Route("/signup", name="signup")
     */
    public function singupAction(Request $request)
    {
        try {
            if($request->getMethod() == 'POST'){
                //get the email from the request
                $email = $request->get('email');
                //create the User object with the email
                $user_to_register = User::register($email);
                //store it in the database
                $em = $this->getDoctrine()->getManager();
                $em->persist($user_to_register);
                $em->flush();

                return $this->redirectToRoute('homepage', array('success' => true));
            }
            
        } catch (\Exception $e) {
           
        }
         return $this->redirectToRoute('homepage', array('success' => false));
    }

}
