<?php
namespace Main\Model\Player\Technology;

use Doctrine\ORM\Mapping as ORM;
use Main\Model\Player\Technology,
    Main\Model\Player\Unit,
    Main\Model\Player\Building,
    Main\Model\Player\Supply;

/**
 * Pozwala rekrutować rycerzy.
 *
 * @ORM\Entity
 */
class Cavalry extends Technology
{
    const PRICE_SCIENCE = 2;
    const CAPACITY_KNIGHTS = 2;

    public function requiredTechnologies()
    {
        return [
            Technology\Warfare::class,
        ];
    }

    /**
     * @return string[]
     */
    public function availableAssets()
    {
        return [
            Unit\Knight::class,
        ];
    }

}