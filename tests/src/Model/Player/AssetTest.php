<?php
namespace MainTest\Model\Player;

use PHPUnit\Framework\TestCase;
use Main\Model\Player\Asset;
use Main\Model\Player;

/**
 * Class AssetTest
 * @package MainTest\Model\Player
 * @covers  Asset
 */
class AssetTest extends TestCase
{
    /**
     * @covers Asset::getType()
     */
    public function testGetType()
    {
        $warrior = new Player\Unit\Warrior();
        $this->assertEquals('warrior', $warrior->getType());
    }

    /**
     * @covers Asset::setAmount()
     */
    public function testSetAmount()
    {
        $farm = new Player\Building\Farm([ 'amount' => 1, ]);
        $this->assertEquals(1, $farm->getAmount());

        $farm->setAmount(2);
        $this->assertEquals(2, $farm->getAmount());

        return $farm;
    }

    /**
     * @covers  Asset::addAmount()
     * @depends testSetAmount
     */
    public function testAddAmount(Player\Building\Farm $farm)
    {
        $farm->addAmount(1);
        $this->assertEquals(3, $farm->getAmount());
    }
}
