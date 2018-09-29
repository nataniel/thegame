<?php
namespace Main\Model\Player\Technology;

use Main\Model\Player\Technology,
    Main\Model\Player\Unit,
    Main\Model\Player\Building,
    Main\Model\Player\Supply;

/**
 * Obniża koszt budynków o 1 kamień.
 *
 * @Entity
 */
class Masonry extends Technology
{
    const PRICE_SCIENCE = 5;
    const DISCOUNT_STONE = 1;

    /**
     * @return string[]
     */
    public function availableAssets()
    {
        return [
            Technology\Architecture::class,
        ];
    }
}