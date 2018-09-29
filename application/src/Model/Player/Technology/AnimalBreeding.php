<?php
namespace Main\Model\Player\Technology;

use Main\Model\Player\Technology,
    Main\Model\Player\Unit,
    Main\Model\Player\Building,
    Main\Model\Player\Supply;

/**
 * Obniża koszt jednostek o 1 żywności.
 *
 * @Entity
 */
class AnimalBreeding extends Technology
{
    const PRICE_SCIENCE = 2;
    const UNITS_DISCOUNT = 1;

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
            Technology\Cavalry::class,
        ];
    }

}