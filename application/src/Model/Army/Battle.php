<?php
namespace Main\Model\Army;

class Battle
{
    private $playerArmy;
    private $enemyArmy;

    public function __construct($playerArmy, $enemyArmy)
    {
        $this->playerArmy = $playerArmy;
        $this->enemyArmy = $enemyArmy;
    }
}