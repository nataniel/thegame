<?php
namespace Main\Model\Player\Unit;

use Main\Model\Player\Supply,
    Main\Model\Player\Unit,
    Main\Model\Player\Building,
    Main\Model\Player\Technology;

/**
 * @Entity
 */
class Warrior extends Unit
{
    const PRICE_FOOD = 5;
    const UPKEEP_FOOD = 1;
    const STARTING_AMOUNT = 1;

    /**
     * @param  int $amount
     * @return int[]
     */
    public function getPrice($amount = 1)
    {
        return [
            Supply\Food::class => self::PRICE_FOOD * $amount - $this->animalBreedingDiscount($amount),
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
            Technology\Gathering::class => Technology\Gathering::CAPACITY_WARRIORS,
            Building\Barracks::class => Building\Barracks::CAPACITY_WARRIORS,
        ]);
    }

    /**
     * @return int
     */
    public function getStrength()
    {
        return 2;
    }

    /**
     * @return int
     */
    public function getRange()
    {
        return 1;
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
        return 2;
    }
}