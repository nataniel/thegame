<?php
namespace Main\Model\Player\Event;

use Main\Model\Army;
use Main\Model\Player\Event;
use Main\Model\Player\Unit;

/**
 * @Entity
 */
class Barbarians extends Event
{
    protected function doProcess()
    {
        $playerArmy = Army::createForPlayer($this->player);
        $opforArmy = Army::randomArmy($this->turn);

        $this->addToResult(Unit\Warrior::class, -1);
        return $this;
    }

    public function getImage()
    {
        return 'https://media.giphy.com/media/16ZmZSmOTSgrS/giphy.gif';
    }
}