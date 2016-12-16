<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * EventDraw
 *
 * @ORM\Table(name="event_draw", uniqueConstraints={@UniqueConstraint(name="search_idx", columns={"event_id", "gifter_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventDrawRepository")
 */
class EventDraw
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="eventdraws")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="gifter_id", referencedColumnName="id")
     */
    private $gifter;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="receiver_id", referencedColumnName="id")
     */
    private $receiver;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set event
     *
     * @param \AppBundle\Entity\Event $event
     *
     * @return EventDraw
     */
    public function setEvent(\AppBundle\Entity\Event $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \AppBundle\Entity\Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set gifter
     *
     * @param \AppBundle\Entity\User $gifter
     *
     * @return EventDraw
     */
    public function setGifter(\AppBundle\Entity\User $gifter = null)
    {
        $this->gifter = $gifter;

        return $this;
    }

    /**
     * Get gifter
     *
     * @return \AppBundle\Entity\User
     */
    public function getGifter()
    {
        return $this->gifter;
    }

    /**
     * Set receiver
     *
     * @param \AppBundle\Entity\User $receiver
     *
     * @return EventDraw
     */
    public function setReceiver(\AppBundle\Entity\User $receiver = null)
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * Get receiver
     *
     * @return \AppBundle\Entity\User
     */
    public function getReceiver()
    {
        return $this->receiver;
    }
}
