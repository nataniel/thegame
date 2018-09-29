<?php
namespace MainTest\Model\Player;

use PHPUnit\Framework\TestCase;
use Main\Model\Player\Supply;

/**
 * Class SupplyTest
 * @package MainTest\Model\Player
 * @covers  Supply
 */
class SupplyTest extends TestCase
{
    /**
     * @covers Supply::getClassFromType()
     */
    public function testGetClassFromType()
    {
        $this->assertEquals(Supply\Food::class,
            Supply::getClassFromType('food'));

        $asset = new Supply\Gold();
        $this->assertEquals(get_class($asset),
            Supply::getClassFromType($asset->getType()));
    }

    /**
     * @covers Supply::__toString()
     */
    public function testToString()
    {
        $supply = new Supply\Food();
        $this->assertEquals('player.supply.food.name', (string)$supply);
    }
}