<?php
namespace Main\Model\Player\Building;

use Main\Model\Player\Building,
    Main\Model\Player\Supply,
    Main\Model\Player\Technology;

/**
 * @Entity
 */
class Monastery extends Building
{
    const CAPACITY_CLERICS = 5;

    const PRICE_STONE = 5;
    const PRICE_GOLD = 1;

    /**
     * @return int
     */
    private function getPriceStone()
    {
        return self::PRICE_STONE
            - $this->player->hasDevelopedTechnology(Technology\Masonry::class)
            * Technology\Masonry::DISCOUNT_STONE;
    }

    /**
     * @param  int $amount
     * @return int[]
     */
    public function getPrice($amount = 1)
    {
        return [
            Supply\Stone::class => $this->getPriceStone() * $amount,
            Supply\Gold::class => self::PRICE_GOLD * $amount,
        ];
    }
}