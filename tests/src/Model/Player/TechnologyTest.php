<?php
namespace MainTest\Model\Player;

use Main\Model\Player;
use PHPUnit\Framework\TestCase;
use Main\Model\Player\Technology;

/**
 * Class TechnologyTest
 * @package MainTest\Model\Player
 * @covers  Technology
 */
class TechnologyTest extends TestCase
{
    /**
     * @covers Technology::isDeveloped()
     * @covers Technology::getProgress()
     * @return Technology\Gathering
     */
    public function testIsAvailable()
    {
        $technology = new Technology\Gathering([ 'player' => new Player() ]);

        $this->assertFalse($technology->isDeveloped());
        $this->assertEquals(0, $technology->getProgress());
        return $technology;
    }

    /**
     * @depends testIsAvailable
     * @covers Technology::setDeveloped()
     * @param  Technology $technology
     * @return Technology\Gathering
     */
    public function testSetAvailable(Technology $technology)
    {
        $technology->setDeveloped();
        $this->assertTrue($technology->isDeveloped());
        $this->assertEquals(Technology::PROGRESS_FULL, $technology->getProgress());
        return $technology;
    }

    /**
     * @depends testSetAvailable
     * @covers Technology::canBeDeveloped()
     * @covers Technology::prospectiveTechnologies()
     * @param  Technology $technology
     * @return Technology\Gathering
     */
    public function testCanBeDeveloped(Technology $technology)
    {
        $farming = new Technology\Farming([ 'player' => $technology->getPlayer(), ]);
        $this->assertTrue($farming->canBeDeveloped());
    }

    /**
     * @covers Technology::getType()
     */
    public function testGetType()
    {
        $farming = new Technology\Farming();
        $this->assertEquals('farming', $farming->getType());
    }

    /**
     * @covers Technology::addScience()
     * @covers Technology::isDeveloped()
     */
    public function testAddScience()
    {
        $technology = new Technology\Farming();
        $this->assertEquals(2, $technology->getPriceScience());

        $technology->addScience(1);
        $this->assertEquals(50, $technology->getProgress());
        $this->assertFalse($technology->isDeveloped());

        $technology->addScience(1);
        $this->assertEquals(100, $technology->getProgress());
        $this->assertTrue($technology->isDeveloped());
    }

    /**
     * @covers Technology::__toString()
     */
    public function testToString()
    {
        $farming = new Technology\Farming();
        $this->assertEquals('player.technology.farming.name', (string)$farming);
    }
}