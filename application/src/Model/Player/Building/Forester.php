<?php
namespace Main\Model\Player\Building;
use Main\Model\Player\Building,
    Main\Model\Player\Supply;

/**
 * @Entity
 */
class Forester extends Building
{
    const PRODUCTION_FOOD = 1;
    const PRODUCTION_WOOD = 1;

    const PRICE_FOOD = 1;
    const PRICE_WOOD = 2;

    /**
     * @param  int $amount
     * @return int[]
     */
    public function getPrice($amount = 1)
    {
        return [
            Supply\Food::class => self::PRICE_FOOD * $amount,
            Supply\Wood::class => self::PRICE_WOOD * $amount,
        ];
    }
}