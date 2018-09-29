<?php
namespace Main\Model\Player\Technology;

use Main\Model\Player\Technology,
    Main\Model\Player\Unit,
    Main\Model\Player\Building,
    Main\Model\Player\Supply;

/**
 * Zwiększa limit budynków o 1. Pozwala budować kościoły, zwiększające limit kleryków.
 *
 * @Entity
 */
class Architecture extends Technology
{
    const PRICE_SCIENCE = 2;
    const LIMIT_BUILDINGS = 1;

    /**
     * @return string[]
     */
    public function availableAssets()
    {
        return [
            Building\Monastery::class,
        ];
    }
}