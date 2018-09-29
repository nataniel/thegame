<?php
namespace Main\Model\Player\Technology;

use Main\Model\Player\Technology,
    Main\Model\Player\Unit,
    Main\Model\Player\Building,
    Main\Model\Player\Supply;

/**
 * Pozwala budować koszary, aby zatrudniać więcej zbrojnych.
 *
 * @Entity
 */
class Warfare extends Technology
{
    const PRICE_SCIENCE = 2;

    /**
     * @return string[]
     */
    public function availableAssets()
    {
        return [
            Technology\AnimalBreeding::class,
            Technology\Archery::class,

            Building\Barracks::class,
        ];
    }
}