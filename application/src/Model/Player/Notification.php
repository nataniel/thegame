<?php
namespace Main\Model\Player;

use E4u\Model\Entity;
use Main\Model\Player;

/**
 * @Entity
 * @Table(name="players_notifications")
 */
class Notification extends Entity
{
    /**
     * @var Player
     * @ManyToOne(targetEntity="Main\Model\Player", inversedBy="notifications")
     */
    protected $player;

    /** @Column(type="string") */
    protected $message;

    /** @Column(type="string") */
    protected $type;

    /** @Column(type="datetime") */
    protected $created_at;

    /**
     * @return Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }
}