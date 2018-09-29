<?php
namespace MainTest\Model\Player;

use PHPUnit\Framework\TestCase;
use Main\Model\Player\Building;

/**
 * Class BuildingTest
 * @package MainTest\Model\Player
 * @covers  Building
 */
class BuildingTest extends TestCase
{
    /**
     * @covers Building::getClassFromType()
     */
    public function testGetClassFromType()
    {
        $this->assertEquals(Building\Farm::class,
            Building::getClassFromType('farm'));

        $asset = new Building\Barracks();
        $this->assertEquals(get_class($asset),
            Building::getClassFromType($asset->getType()));
    }

    /**
     * @covers Building::__toString()
     */
    public function testToString()
    {
        $building = new Building\Barracks();
        $this->assertEquals('player.building.barracks.name', (string)$building);
    }
}
