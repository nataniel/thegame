<?php
namespace Main\Model\Player\Event;

use Main\Model\Army;
use Main\Model\Player\Event;
use Main\Model\Player\Unit;
use Main\Model\Game;

/**
 * @Entity
 */
class Barbarians extends Event
{
    protected function doInitialize()
    {
        return $this;
    }

    protected function doResolve($option)
    {
        switch ($option) {
            case 1:
                $this->sacrificeWarrior();
                break;

            case 2:
                $this->fightWithArmy();
                break;

            default:
                throw new Game\Exception('Wybierz opcję walki z barbarzyńcami.');
                break;
        }

        # $playerArmy = Army::createForPlayer($this->player);
        # $opforArmy = Army::randomArmy($this->turn);
        return $this;
    }

    protected function sacrificeWarrior()
    {
        $this->applyResult([ Unit\Warrior::class => -1 ]);
        return $this;
    }

    protected function fightWithArmy()
    {
        $this->applyResult([ Unit\Warrior::class => rand(-2, 0) ]);
        return $this;
    }

    public function getImage()
    {
        return '//media.giphy.com/media/16ZmZSmOTSgrS/giphy.gif';
    }
}