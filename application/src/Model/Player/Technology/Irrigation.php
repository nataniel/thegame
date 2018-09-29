<?php
namespace Main\Model\Player\Technology;

use Main\Model\Player\Technology,
    Main\Model\Player\Unit,
    Main\Model\Player\Building,
    Main\Model\Player\Supply;

/**
 * Zwiększa wydajność farm o 1.
 *
 * @Entity
 */
class Irrigation extends Technology
{
    const PRICE_SCIENCE = 2;
    const INCREASE_FOOD = 1;

    /**
     * @return string[]
     */
    public function availableAssets()
    {
        return [];
    }

}