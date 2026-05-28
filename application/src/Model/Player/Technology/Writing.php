<?php
namespace Main\Model\Player\Technology;

use Doctrine\ORM\Mapping as ORM;
use Main\Model\Player\Technology,
    Main\Model\Player\Unit,
    Main\Model\Player\Building,
    Main\Model\Player\Supply;

/**
 * Zapewnia niewielką ilość nauki.
 *
 * @ORM\Entity
 */
class Writing extends Technology
{
    const PRICE_SCIENCE = 2;
    const PRODUCTION_SCIENCE = 1;

    /**
     * @return string[]
     */
    public function availableAssets()
    {
        return [
            Technology\Literature::class,
        ];
    }
}