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
class Science extends Supply
{
    /**
     * @return int[]
     */
    public function productionMap()
    {
        return $this->buildMap([
            Technology\Gathering::class => Technology\Gathering::PRODUCTION_SCIENCE,
            Technology\Writing::class   => Technology\Writing::PRODUCTION_SCIENCE,
            Unit\Cleric::class  => Unit\Cleric::PRODUCTION_SCIENCE,
        ]);
    }
}