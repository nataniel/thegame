<?php
namespace Main\Model;

class Army
{
    private $units;

    public function __construct($unitList)
    {
        foreach ($unitList as $unitType => $amount) {
            for ($i = 0; $i < $amount; $i++) {
                $this->units[] = new Army\Unit($unitType);
            }
        }
    }

    public function getUnits()
    {
        return $this->units;
    }

    /**
     * @param  Player $player
     * @return Army
     */
    public static function createForPlayer(Player $player)
    {
        $unitList = [];
        foreach ($player->getAvailableUnits() as $availableUnit) {

            $unitList[ get_class($availableUnit) ] = $availableUnit->getAmount();

        }

        return new Army($unitList);
    }

    /**
     * @param  int $turn
     * @return Army
     */
    public static function randomArmy($turn)
    {
        return new Army([
            Player\Unit\Warrior::class => 2,
            Player\Unit\Archer::class => rand(0, $turn),
        ]);
    }
}