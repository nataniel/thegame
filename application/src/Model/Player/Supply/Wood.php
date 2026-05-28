<?php
namespace Main\Model\Player\Supply;

use Doctrine\ORM\Mapping as ORM;
use Main\Model\Player\Supply,
    Main\Model\Player\Unit,
    Main\Model\Player\Building,
    Main\Model\Player\Technology;

/**
 * @ORM\Entity
 */
class Wood extends Supply
{
    const STARTING_AMOUNT = 2;

    /**
     * @return int[]
     */
    public function productionMap()
    {
        return $this->buildMap([
            Technology\Gathering::class => Technology\Gathering::PRODUCTION_WOOD,
            Building\Forester::class  => Building\Forester::PRODUCTION_WOOD,
        ]);
    }
}