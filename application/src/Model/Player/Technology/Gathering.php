<?php
namespace Main\Model\Player\Technology;

use Main\Model\Player\Technology,
    Main\Model\Player\Unit,
    Main\Model\Player\Building,
    Main\Model\Player\Supply;

/**
 * Podstawowa technologia, daje minimalną produkcję żywności, drewna i nauki.
 *
 * @Entity
 */
class Gathering extends Technology
{
    const PRICE_SCIENCE = 0;

    const PRODUCTION_FOOD = 2;
    const PRODUCTION_WOOD = 1;
    const PRODUCTION_SCIENCE = 1;
    const CAPACITY_WARRIORS = 2;

    /**
     * @return string[]
     */
    public function availableAssets()
    {
        return [
            Technology\Farming::class,
            Technology\Warfare::class,
            Technology\Stoneworks::class,

            Building\Forester::class,
            Unit\Warrior::class,

            Supply\Food::class,
            Supply\Wood::class,
            Supply\Science::class,
        ];
    }
}