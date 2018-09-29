<?php
namespace Main\Model\Player\Technology;

use Main\Model\Player\Technology,
    Main\Model\Player\Unit,
    Main\Model\Player\Building,
    Main\Model\Player\Supply;

/**
 * Każda kopalnia wydobywa dodatkowo 1 złota.
 *
 * @Entity
 */
class GoldMining extends Technology
{
    const PRICE_SCIENCE = 2;

    /**
     * @return string[]
     */
    public function availableAssets()
    {
        return [

        ];
    }

}