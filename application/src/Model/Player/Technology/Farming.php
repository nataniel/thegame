<?php
namespace Main\Model\Player\Technology;

use Main\Model\Player\Technology;
use Main\Model\Player\Unit,
    Main\Model\Player\Building,
    Main\Model\Player\Supply;

/**
 * Pozwala budować farmy, które wytwarzają żywność.
 *
 * @Entity
 */
class Farming extends Technology
{
    const PRICE_SCIENCE = 2;

    /**
     * @return string[]
     */
    public function availableAssets()
    {
        return [
            Technology\Irrigation::class,
            Technology\Writing::class,

            Building\Farm::class,

            Supply\Food::class,
        ];
    }
}