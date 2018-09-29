<?php
namespace Main\Model\Player\Technology;

use Main\Model\Player\Technology,
    Main\Model\Player\Unit,
    Main\Model\Player\Building,
    Main\Model\Player\Supply;

/**
 * Pozwala budować łuczników.
 *
 * @Entity
 */
class Archery extends Technology
{
    const PRICE_SCIENCE = 2;

    const CAPACITY_ARCHERS = 2;

    public function requiredTechnologies()
    {
        return [
            Technology\Irrigation::class,
        ];
    }

    /**
     * @return string[]
     */
    public function availableAssets()
    {
        return [
            Unit\Archer::class,
        ];
    }
}