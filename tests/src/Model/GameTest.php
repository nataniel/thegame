<?php
namespace MainTest\Model;

use PHPUnit\Framework\TestCase;
use Main\Model\Game;
use Main\Model\User;
use Main\Model\Player;

/**
 * Class GameTest
 * @package MainTest\Model
 * @covers  Game
 */
class GameTest extends TestCase
{
    /**
     * @covers Game::joinUser()
     * @covers Game::removeUser()
     */
    public function testJoinAndRemoveUser()
    {
        $game = new Game([ 'max_players' => 2 ]);
        $this->assertCount(0, $game->getPlayers());

        $userA = new User();
        $game->joinUser($userA);
        $this->assertCount(1, $game->getPlayers());

        $userB = new User();
        $game->joinUser($userB);
        $this->assertCount(2, $game->getPlayers());

        $game->removeUser($userA);
        $this->assertCount(1, $game->getPlayers());
    }

    /**
     * @covers Game::removeUser()
     */
    public function testRemoveUserNotPlayer()
    {
        $game = new Game();
        $this->expectException(Game\Exception::class);
        $this->expectExceptionCode(Game\Exception::USER_IS_NOT_PLAYER);

        $game->joinUser(new User());
        $game->removeUser(new User());
    }

    /**
     * @covers Game::removeUser()
     */
    public function testRemoveUserGameAlreadyLaunched()
    {
        $game = new Game();
        $this->expectException(Game\Exception::class);
        $this->expectExceptionCode(Game\Exception::GAME_ALREADY_LAUNCHED);

        $user = new User();
        $game->joinUser($user);

        $game->setCurrentStatus(Game::STATUS_WAITING + 1);
        $game->removeUser($user);
    }

    /**
     * @covers Game::joinUser()
     */
    public function testJoinUserAlreadyJoined()
    {
        $game = new Game();
        $this->expectException(Game\Exception::class);
        $this->expectExceptionCode(Game\Exception::USER_ALREADY_JOINED);

        $user = new User();
        $game->joinUser($user);
        $game->joinUser($user);
    }

    /**
     * @covers Game::joinUser()
     */
    public function testJoinUserMaxPlayersReached()
    {
        $game = new Game([ 'max_players' => 2 ]);
        $this->expectException(Game\Exception::class);
        $this->expectExceptionCode(Game\Exception::MAX_PLAYERS_REACHED);

        $game->joinUser(new User());
        $game->joinUser(new User());
        $game->joinUser(new User());
    }

    /**
     * @covers Game::joinUser()
     */
    public function testJoinUserGameAlreadyLaunched()
    {
        $game = new Game([ 'current_status' => Game::STATUS_WAITING + 1 ]);
        $this->expectException(Game\Exception::class);
        $this->expectExceptionCode(Game\Exception::GAME_ALREADY_LAUNCHED);

        $game->joinUser(new User());
    }

    /**
     * @covers Game::start()
     */
    public function testStartGame()
    {
        $game = new Game([ 'current_status' => Game::STATUS_WAITING ]);
        $game->joinUser(new User());
        $game->joinUser(new User());
        $game->joinUser(new User());

        $game->start();
        $this->assertEquals(Game::STATUS_STARTED, $game->getCurrentStatus());
    }

    /**
     * @covers Game::restart()
     */
    public function testRestartGame()
    {
        $game = new Game([ 'current_status' => Game::STATUS_WAITING ]);
        $game->joinUser(new User());
        $game->joinUser(new User());
        $game->joinUser(new User());
        $game->start();

        $startingValues = [];

        /** @var Player $player */
        $player = $game->getPlayers()->first();
        foreach ($player->getAvailableSupplies() as $type => $assets) {
            foreach ($assets as $asset) {

                /** @var $asset Player\Asset */
                $startingValues[$type][$asset->getType()] = $asset->getAmount();
                $asset->setAmount(rand(0, 10));

            }
        }

        $game->restart();
        $this->assertEquals(Game::STATUS_STARTED, $game->getCurrentStatus());
        $this->assertEquals(3, $game->getNumberOfPlayers());

        $player = $game->getPlayers()->first();
        foreach ($player->getAvailableSupplies() as $type => $assets) {
            foreach ($assets as $asset) {

                /** @var $asset Player\Asset */
                $this->assertEquals($startingValues[$type][$asset->getType()], $asset->getAmount());

            }
        }
    }

    /**
     * @covers Game::isEndTurnReady()
     */
    public function testIsEndTurnReady()
    {
        $game = new Game([ 'current_status' => Game::STATUS_WAITING ]);
        $game->joinUser(new User());
        $game->joinUser(new User());
        $this->assertFalse($game->isEndTurnReady());

        foreach ($game->getPlayers() as $player) {
            $player->beginTurnPhase();
            $player->productionPhase();
            $player->eventResolutionPhase();
            $player->developmentPhase();
            $player->actionPhase();
            $player->endTurnPhase();
        }

        $this->assertTrue($game->isEndTurnReady());
    }

    /**
     * @covers Game
     */
    public function testGameTurnFlow()
    {
        $game = new Game([ 'name' => 'Gra testowa', 'max_players' => 1, ]);
        $this->assertEquals(Game::STATUS_WAITING, $game->getCurrentStatus());

        $playerA = $game->joinUser(new User());
        $this->assertEquals(1, $game->getNumberOfPlayers());

        $game->start();
        $this->assertEquals(Game::STATUS_STARTED, $game->getCurrentStatus());
        $this->assertEquals(1, $game->getCurrentTurn());
        $this->assertEquals(Player::PHASE_BEGINTURN, $playerA->getCurrentPhase());

        $playerA->beginTurnPhase();
        $playerA->productionPhase();
        $playerA->eventResolutionPhase();
        $playerA->developmentPhase();
        $playerA->actionPhase();
        $playerA->endTurnPhase();
        $game->tryNextTurn();

        $this->assertEquals(Player::PHASE_BEGINTURN, $playerA->getCurrentPhase());
        $this->assertEquals(2, $game->getCurrentTurn());
    }
}