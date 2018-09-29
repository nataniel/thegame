<?php
namespace Main\Model\Player\Unit;
use Main\Model\Player\Supply,
    Main\Model\Player\Unit,
    Main\Model\Player\Building,
    Main\Model\Player\Technology;

/**
 * @Entity
 */
class Archer extends Unit
{
    const PRICE_FOOD = 2;
    const PRICE_WOOD = 2;
    const UPKEEP_FOOD = 1;

    /**
     * @param  int $amount
     * @return int[]
     */
    public function getPrice($amount = 1)
    {
        return [
            Supply\Food::class => self::PRICE_FOOD * $amount - $this->animalBreedingDiscount($amount),
            Supply\Wood::class => self::PRICE_WOOD * $amount,
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
            Technology\Archery::class => Technology\Archery::CAPACITY_ARCHERS,
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
        return 4;
    }

    /**
     * @return int
     */
    public function getDefense()
    {
        return 1;
    }

    /**
     * @return int
     */
    public function getSpeed()
    {
        return 1;
    }
}