<?php
namespace Main\Model\Player\Event;

use Main\Model\Army;
use Main\Model\Player\Event;
use Main\Model\Player\Unit;
use Main\Model\Game;

/**
 * @Entity
 */
class Raiders extends Event
{
    protected function doInitialize()
    {
        return $this;
    }

    protected function doResolve($option)
    {
        switch ($option) {
            case 1:
                $this->fight();
                break;

            case 2:
                $this->pay();
                break;

            case 3:
                $this->flee();
                break;

            default:
                throw new Game\Exception('Wybierz opcję walki z grabieżcami.');
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

    protected function pay()
    {
        // - Panowie, jakoś się dogadamy...
        $this->applyResult([ Unit\Warrior::class => rand(-2, 0) ]);
        return $this;
    }

    protected function flee()
    {
        // - Kto żyw niech uchodzi do boru, przeczekamy tam aż sobie pójdą!
        $this->applyResult();
        return $this;
    }
}