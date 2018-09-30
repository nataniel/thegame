<?php
namespace Main\Model\Player\Building;

use Main\Model\Player\Building,
    Main\Model\Player\Supply;

/**
 * @Entity
 */
class Barracks extends Building
{
    const CAPACITY_WARRIORS = 5;

    const PRICE_WOOD = 5;

    /**
     * @param  int $amount
     * @return int[]
     */
    public function getPrice($amount = 1)
    {
        return [
            Supply\Wood::class => self::PRICE_WOOD * $amount,
        ];
    }
}