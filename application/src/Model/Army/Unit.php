<?php
namespace Main\Model\Army;

class Unit
{
    const MAX_HEALTH = 100;

    private $type;
    private $health = self::MAX_HEALTH;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function isAlive()
    {
        return $this->health > 0;
    }

    public function isDead()
    {
        return !$this->isAlive();
    }
}