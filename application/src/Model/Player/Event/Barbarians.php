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
    protected function doResolve($option)
    {
        switch ($option) {
            case 1:
                $this->fight();
                break;

            default:
                throw new Game\Exception('Wybierz opcję walki z barbarzyńcami.');
                break;
        }

        # $playerArmy = Army::createForPlayer($this->player);
        # $opforArmy = Army::randomArmy($this->turn);
        return $this;
    }

    protected function fight()
    {
        // - Do boju dzielni wojowie! Odeprzemy tę zarazę!
        $this->applyResult([ Unit\Warrior::class => -1 ]);
        return $this;
    }
}