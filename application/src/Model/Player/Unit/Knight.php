<?php
namespace Main\Model\Player\Unit;
use Main\Model\Player\Supply,
    Main\Model\Player\Unit,
    Main\Model\Player\Building,
    Main\Model\Player\Technology;

/**
 * @Entity
 */
class Knight extends Unit
{
    const PRICE_FOOD = 4;
    const PRICE_WOOD = 2;
    const PRICE_GOLD = 1;
    const UPKEEP_GOLD = 1;

    /**
     * @param  int $amount
     * @return int[]
     */
    public function getPrice($amount = 1)
    {
        return [
            Supply\Food::class => self::PRICE_FOOD * $amount - $this->animalBreedingDiscount($amount),
            Supply\Wood::class => self::PRICE_WOOD * $amount,
            Supply\Gold::class => self::PRICE_GOLD * $amount,
        ];
    }

    /**
     * @return int[]
     */
    public function getUpkeep()
    {
        return [
            Supply\Gold::class => self::UPKEEP_GOLD * $this->amount,
        ];
    }

    /**
     * @return int[]
     */
    public function capacityMap()
    {
        return $this->buildMap([
            Technology\Cavalry::class => Technology\Cavalry::CAPACITY_KNIGHTS,
        ]);
    }

    /**
     * @return int
     */
    public function getStrength()
    {
        return 5;
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
        return 4;
    }

    /**
     * @return int
     */
    public function getSpeed()
    {
        return 2;
    }
}