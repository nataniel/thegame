<?php
namespace Main\Model\Player\Technology;

use Main\Model\Player\Technology,
    Main\Model\Player\Unit,
    Main\Model\Player\Building,
    Main\Model\Player\Supply;

/**
 * Wydobycie kamienia + 1.
 *
 * @Entity
 */
class Stoneworks extends Technology
{
    const PRICE_SCIENCE = 2;
    const PRODUCTION_STONE = 1;

    /**
     * @return string[]
     */
    public function availableAssets()
    {
        return [
            Technology\Mining::class,
            Technology\Religion::class,
            Supply\Stone::class,
        ];
    }
}