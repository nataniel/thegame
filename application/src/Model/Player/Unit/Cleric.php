<?php
namespace Main\Model\Player\Unit;

use Main\Model\Player\Supply,
    Main\Model\Player\Unit,
    Main\Model\Player\Building,
    Main\Model\Player\Technology;

/**
 * @Entity
 */
class Cleric extends Unit
{
    const PRODUCTION_SCIENCE = 1;

    const PRICE_FOOD = 2;
    const PRICE_GOLD = 2;
    const UPKEEP_FOOD = 1;

    /**
     * @param  int $amount
     * @return int[]
     */
    public function getPrice($amount = 1)
    {
        return [
            Supply\Food::class => self::PRICE_FOOD * $amount - $this->animalBreedingDiscount($amount),
            Supply\Gold::class => self::PRICE_GOLD * $amount,
        ];
    }

    /**
     * @return int[]
     */
    public function getUpkeep()
    {
        return [
            Supply\Food::class => self::UPKEEP_FOOD * $this->amount,
        ];
    }

    /**
     * @return int[]
     */
    public function capacityMap()
    {
        return $this->buildMap([
            Technology\Religion::class => Technology\Religion::CAPACITY_CLERICS,
            Building\Monastery::class => Building\Monastery::CAPACITY_CLERICS,
        ]);
    }


    /**
     * @return int
     */
    public function getStrength()
    {
        return 1;
    }

    /**
     * @return int
     */
    public function getRange()
    {
        return 0;
    }

    /**
     * @return int
     */
    public function getDefense()
    {
        return 2;
    }

    /**
     * @return int
     */
    public function getSpeed()
    {
        return 1;
    }
}