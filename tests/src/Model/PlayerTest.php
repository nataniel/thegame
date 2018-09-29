<?php
namespace MainTest\Model;

use PHPUnit\Framework\TestCase;
use Main\Model\Player,
    Main\Model\Game,
    Main\Model\User;

use Main\Model\Player\Building,
    Main\Model\Player\Unit,
    Main\Model\Player\Supply,
    Main\Model\Player\Technology;

/**
 * Class PlayerTest
 * @package MainTest\Model
 * @covers  Player
 */
class PlayerTest extends TestCase
{
    /**
     * @covers Player::getGame()
     * @covers Player::setGame()
     */
    public function testGetGame()
    {
        $player = new Player([ 'game' => new Game(), ]);
        $this->assertInstanceOf(Game::class, $player->getGame());
        $this->assertCount(1, $player->getGame()->getPlayers());
    }

    /**
     * @covers Player::getUnits()
     * @covers Player::getUnitByType()
     */
    public function testGetUnits()
    {
        $player = new Player([ 'game' => new Game(), 'user' => new User() ]);
        $player->getUnitByType('archer');
        $this->assertCount(1, $player->getUnits());

        new Player\Unit\Warrior([ 'player' => $player, ]);
        $this->assertCount(2, $player->getUnits());
    }

    /**
     * @covers Player::getBuildings()
     * @covers Player::getBuildingByType()
     */
    public function testGetBuildings()
    {
        $player = new Player([ 'game' => new Game(), 'user' => new User() ]);
        $player->getBuildingByType('farm')->setAmount(2);
        $this->assertEquals(2,
            $player->getBuildingByType(Player\Building\Farm::class)->getAmount());

        $assets = $player->getBuildings();
        $this->assertCount(1, $assets);

        new Player\Building\Barracks([ 'player' => $player, 'amount' => 2 ]);
        $this->assertEquals(2,
            $player->getBuildingByType(Player\Building\Barracks::class)->getAmount());
        $this->assertCount(2, $assets);
    }

    /**
     * @covers Player::getSupplies()
     * @covers Player::getSupplyByType()
     */
    public function testGetSupplies()
    {
        $player = new Player([ 'game' => new Game(), 'user' => new User() ]);
        $player->getSupplyByType('food')->setAmount(10);
        $this->assertEquals(10,
            $player->getSupplyByType(Player\Supply\Food::class)->getAmount());

        $assets = $player->getSupplies();
        $this->assertCount(1, $assets);

        new Player\Supply\Gold([ 'player' => $player, 'amount' => 5 ]);
        $this->assertCount(2, $assets);
        $this->assertEquals(5,
            $player->getSupplyByType(Player\Supply\Gold::class)->getAmount());
    }

    /**
     * @covers Player::getAssetByClass()
     */
    public function testGetAssetByClass()
    {
        $player = new Player();
        $unit = $player->getAssetByClass(Unit\Archer::class);
        $this->assertInstanceOf(Unit\Archer::class, $unit);

        $unit = $player->getAssetByClass(Unit\Warrior::class);
        $this->assertInstanceOf(Unit\Warrior::class, $unit);

        $building = $player->getAssetByClass(Building\Farm::class);
        $this->assertInstanceOf(Building\Farm::class, $building);

        $supply = $player->getAssetByClass(Supply\Food::class);
        $this->assertInstanceOf(Supply\Food::class, $supply);

        $technology = $player->getAssetByClass(Technology\Farming::class);
        $this->assertInstanceOf(Technology\Farming::class, $technology);
    }

    /**
     * @return Player
     * @covers Player::setTechnologies()
     * @covers Player::hasDevelopedTechnology()
     */
    public function testSetTechnologies()
    {
        $player = new Player();
        $player->setTechnologies([ new Technology\Gathering([ 'developed' => true ]) ]);

        $this->assertTrue($player->hasDevelopedTechnology(Technology\Gathering::class));
        $this->assertFalse($player->hasDevelopedTechnology(Technology\Farming::class));
        return $player;
    }

    /**
     * @param   Player $player
     * @covers  Player::getProductionAmountOf()
     * @depends testSetTechnologies
     */
    public function testGetProductionAmountOf(Player $player)
    {
        $this->assertEquals(Technology\Gathering::PRODUCTION_FOOD, $player->getProductionAmountOf(Supply\Food::class));
        $this->assertEquals(0, $player->getProductionAmountOf(Supply\Gold::class));
    }

    /**
     * @covers Player::getTotalStrength()
     */
    public function testGetTotalStrength()
    {
        $player = new Player();
        $this->assertEquals(0, $player->getTotalStrength());
    }
}