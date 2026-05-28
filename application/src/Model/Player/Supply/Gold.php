<?php
namespace Main\Model\Player\Supply;

use Doctrine\ORM\Mapping as ORM;
use Main\Model\Player\Supply,
    Main\Model\Player\Unit,
    Main\Model\Player\Building,
    Main\Model\Player\Technology;

/**
 * Złoto jest jokerem, który może zastąpić dowolny surowiec.
 *
 * @ORM\Entity
 */
class Gold extends Supply
{
    /**
     * @return int[]
     */
    public function productionMap()
    {
        return $this->buildMap([
            Building\Mine::class => Building\Mine::PRODUCTION_GOLD * $this->getPlayer()->hasDevelopedTechnology(Technology\GoldMining::class),
        ]);
    }
}