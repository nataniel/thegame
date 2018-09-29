<?php
namespace Main\Model\Player\Technology;

use Main\Model\Player\Technology,
    Main\Model\Player\Unit,
    Main\Model\Player\Building,
    Main\Model\Player\Supply;

/**
 * Pozwala zatrudniać kleryków, którzy leczą jednostki w walce i dają małą premię do nauki.
 *
 * @Entity
 */
class Religion extends Technology
{
    const PRICE_SCIENCE = 2;
    const CAPACITY_CLERICS = 2;

    /**
     * @return string[]
     */
    public function availableAssets()
    {
        return [
            Unit\Cleric::class,
        ];
    }
}