<?php
namespace Main\Model\Player\Event;

use Main\Model\Army;
use Main\Model\Player\Event;
use Main\Model\Player\Unit;
use Main\Model\Player\Supply;
use Main\Model\Game;

/**
 * @Entity
 */
class Raiders extends Event
{
    const FIGHT = 1,
        PAY = 2,
        FLEE = 3;

    protected function doResolve($option)
    {
        switch ($option) {
            case self::FIGHT:
                $this->fight();
                break;

            case self::PAY:
                $this->pay();
                break;

            case self::FLEE:
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

    /**
     * @return Army
     */
    public function getEnemyArmy()
    {
        srand($this->random_seed);
        return Army::randomArmy($this->player->getCurrentTurn());
    }

    /**
     * @return Army
     */
    public function getPlayerArmy()
    {
        return Army::createForPlayer($this->player);
    }

    /**
     * @param  int $option
     * @return bool
     */
    public function isResolutionOptionAvailable($option)
    {
        switch ($option) {
            case self::FIGHT:
                return $this->player->getTotalStrength() > 0;

            case self::PAY:
                return $this->player->getSupplyByType(Supply\Gold::class)->getAmount() > 0;

            case self::FLEE:
                return true;

            default:
                return false;
        }
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
        $this->applyResult([ Supply\Gold::class => -1 ]);
        return $this;
    }

    protected function flee()
    {
        // - Kto żyw niech uchodzi do boru, przeczekamy tam aż sobie pójdą!
        $this->applyResult();
        return $this;
    }
}