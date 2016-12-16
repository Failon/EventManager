<?php

namespace AppBundle\Service;

#Doctrine
use Doctrine\ORM\EntityManager;

# Entities
use AppBundle\Entity\User;
use AppBundle\Entity\Event;
use AppBundle\Entity\EventDraw;


/**
* 
*/
class EventSignup
{
	/**
	 * @var EntityManager $em
	 */
	protected $em;
	
	/**
	 * EventSignup Constructor
	 * @param EntityManager $em
	 */
	function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	/**
	 * signup function
	 * @param User $user
	 * @param Event $event
	 */
	public function signUp(User $user, Event $event){
		$return = false;
		//check if the event draw already exists
		$eventDraw = $this->em->getRepository('AppBundle:EventDraw')->findOneBy(array('event' => $event, 'gifter' => $user));

		if(!$eventDraw instanceof EventDraw){
			$eventDraw = new EventDraw();
			$eventDraw->setEvent($event);
			$eventDraw->setGifter($user);
			$this->em->persist($eventDraw);
			$this->em->flush();
			$return = true;
		}
		return $return;
	}
}