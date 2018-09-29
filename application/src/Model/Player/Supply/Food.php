<?php
namespace Main\Model\Player\Supply;
use Main\Model\Player\Supply,
    Main\Model\Player\Unit,
    Main\Model\Player\Building,
    Main\Model\Player\Technology;

/**
 * @Entity
 */
class Food extends Supply
{
    /**
     * @return int[]
     */
    public function productionMap()
    {
        return $this->buildMap([
            Technology\Gathering::class => Technology\Gathering::PRODUCTION_FOOD,
            Building\Farm::class        => Building\Farm::PRODUCTION_FOOD + $this->getPlayer()->hasDevelopedTechnology(Technology\Irrigation::class) * Technology\Irrigation::INCREASE_FOOD,
            Building\Forester::class    => Building\Forester::PRODUCTION_FOOD,
        ]);
    }
}