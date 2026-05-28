<?php
namespace Main\Model\Player;

use Doctrine\ORM\Mapping as ORM;
use E4u\Model\Entity;
use Main\Model\Player;

/**
 * @ORM\Entity
 * @ORM\Table(name="players_notifications")
 */
class Notification extends Entity
{
    /**
     * @var Player
     * @ORM\ManyToOne(targetEntity="Main\Model\Player", inversedBy="notifications")
     */
    protected $player;

    /** @ORM\Column(type="string") */
    protected $message;

    /** @ORM\Column(type="string") */
    protected $type;

    /** @ORM\Column(type="datetime") */
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