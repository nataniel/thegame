<?php
namespace Main\Model\Player\Supply;
use Main\Model\Player\Supply,
    Main\Model\Player\Unit,
    Main\Model\Player\Building,
    Main\Model\Player\Technology;

/**
 * @Entity
 */
class Stone extends Supply
{
    /**
     * @return int[]
     */
    public function productionMap()
    {
        return $this->buildMap([
            Technology\Stoneworks::class => Technology\Stoneworks::PRODUCTION_STONE,
            Building\Mine::class => Building\Mine::PRODUCTION_STONE,
        ]);
    }
}