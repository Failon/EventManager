<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

# Entities
use AppBundle\Entity\User;
use AppBundle\Entity\Event;

#Exceptions
use AppBundle\Exceptions\EventNotFoundException;

class DefaultController extends Controller
{
    const active_event = 1;

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
        //get the manager
        $em = $this->getDoctrine()->getManager();

        try {
            if($request->getMethod() == 'POST'){
                //get the email from the request
                $email = $request->get('email');
                $event = $request->get('event');
                //find if there is a user with this mail already
                $user = $em->getRepository('AppBundle:User')->findOneBy(array('email' => $email));
                //find the event
                $event = $em->getRepository('AppBundle:Event')->find(self::active_event);

                if(!$event instanceof Event){
                    throw new EventNotFoundException('Event with id '.self::active_event.' not found');
                }

                //If the user exists
                if($user instanceof User) {
                    $user = $em->getRepository('AppBundle:User')->findOneBy(array('email' => $email));
                    $success = $this->get('event.signup')->signUp($user, $event);

                } else { //If the user does not exist
                    //create the User object with the email
                    $userManager = $this->get('fos_user.user_manager');
                    $user_to_register = $userManager->createUser();
                    $user_to_register->setUsername($email);
                    $user_to_register->setEmail($email);
                    $user_to_register->setPlainPassword('1234');
                    $user_to_register->setEnabled(true);
                    //store it in the database
                    $userManager->updateUser($user_to_register);
                    $success = $this->get('event.signup')->signUp($user_to_register, $event);
                }

                return $this->redirectToRoute('homepage', array('success' => $success));
            }
            
        } catch (\Exception $e) {
           throw $e; //Uncomment this line for testing purposes           
        }

        return $this->redirectToRoute('homepage', array('success' => false));
    }
}
