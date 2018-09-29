<?php
namespace Main\Model\Player\Technology;

use Main\Model\Player\Technology,
    Main\Model\Player\Unit,
    Main\Model\Player\Building,
    Main\Model\Player\Supply;

/**
 * Pozwala budować biblioteki, które wytwarzają naukę.
 *
 * @Entity
 */
class Literature extends Technology
{
    const PRICE_SCIENCE = 2;

    public function requiredTechnologies()
    {
        return [
            Technology\Masonry::class,
        ];
    }

    /**
     * @return string[]
     */
    public function availableAssets()
    {
        return [
            Building\Library::class
        ];
    }
}