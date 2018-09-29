<?php
namespace MainTest\Model\Player;

use PHPUnit\Framework\TestCase;
use Main\Model\Player\Unit;
use Main\Model\Player;

/**
 * Class UnitTest
 * @package MainTest\Model\Player
 * @covers  Unit
 */
class UnitTest extends TestCase
{
    /**
     * @covers Unit::maxAmount()
     */
    public function testAddAmountMaxReached()
    {
        $unit = new Unit\Warrior([ 'player' => new Player(), ]);
        $this->expectException(\E4u\Model\Exception::class);
        $unit->addAmount(99999);
    }

    /**
     * @covers Unit::getClassFromType()
     */
    public function testGetClassFromType()
    {
        $this->assertEquals(Unit\Archer::class,
            Unit::getClassFromType('archer'));

        $asset = new Unit\Warrior();
        $this->assertEquals(get_class($asset),
            Unit::getClassFromType($asset->getType()));
    }

    /**
     * @covers Unit::__toString()
     */
    public function testToString()
    {
        $unit = new Unit\Warrior();
        $this->assertEquals('player.unit.warrior.name', (string)$unit);
    }
}