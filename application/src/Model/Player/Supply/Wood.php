<?php
namespace Main\Model\Player\Supply;
use Main\Model\Player\Supply,
    Main\Model\Player\Unit,
    Main\Model\Player\Building,
    Main\Model\Player\Technology;

/**
 * @Entity
 */
class Wood extends Supply
{
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