<?php
namespace Main\Model\Player\Technology;

use Main\Model\Player\Technology,
    Main\Model\Player\Unit,
    Main\Model\Player\Building,
    Main\Model\Player\Supply;

/**
 * Pozwala budować kopalnie, które wytwarzają kamień.
 *
 * @Entity
 */
class Mining extends Technology
{
    const PRICE_SCIENCE = 2;

    /**
     * @return string[]
     */
    public function availableAssets()
    {
        return [
            Technology\Masonry::class,
            Technology\GoldMining::class,
            Building\Mine::class,
            Supply\Gold::class,
        ];
    }
}