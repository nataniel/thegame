<?php
namespace MainTest\Model\Game;

use Main\Model\Game;
use Main\Model\Player;
use Main\Model\User;

class ServerTest extends \PHPUnit_Framework_TestCase
{
    /** @var Game\Server */
    protected $server;

    public function setUp()
    {
        $user = new User();
        $this->server = new Game\Server($user);
    }

    /**
     * @covers Game\Server::createPlayer
     */
    public function testCreatePlayer()
    {
        $this->server->createPlayer();
        $this->assertInstanceOf(Player::class, $this->server->getPlayer());
    }

    /**
     * @covers Game\Server::resetGame
     * @depends testCreatePlayer
     */
    public function testResetGame()
    {
        $player = $this->server->getPlayer();
        $this->server->resetGame();
        $this->assertNotEquals($player, $this->server->getPlayer());
    }

    /**
     * @covers Game\Server::destroyPlayer
     * @depends testCreatePlayer
     */
    public function testDestroyPlayer()
    {
        $this->server->destroyPlayer();
        $this->assertNull($this->server->getPlayer());
    }

}
