<?php
namespace Main\Model\Player\Building;

use Main\Model\Player\Building,
    Main\Model\Player\Supply,
    Main\Model\Player\Technology;

/**
 * @Entity
 */
class Library extends Building
{
    const PRODUCTION_SIENCE = 5;

    const PRICE_WOOD = 5;
    const PRICE_STONE = 2;

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
            Supply\Wood::class => self::PRICE_WOOD * $amount,
            Supply\Stone::class => $this->getPriceStone() * $amount,
        ];
    }
}