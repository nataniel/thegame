<?php
namespace Main\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use E4u\Exception\RuntimeException;
use E4u\Model\Entity;
use Main\Model\Player\Technology,
    Main\Model\Player\Building,
    Main\Model\Player\Unit,
    Main\Model\Player\Supply;

/**
 * @Entity(repositoryClass="Main\Model\Game\Repository")
 * @Table(name="games")
 */
class Game extends Entity
{
    const
        STATUS_WAITING = 1,
        STATUS_STARTED = 5,
        STATUS_FINISHED = 100;

    /** @Column(type="string") */
    protected $name;

    /** @Column(type="integer") */
    protected $current_status = self::STATUS_WAITING;

    /** @Column(type="integer") */
    protected $max_players = 4;

    /** @Column(type="integer", nullable=true) */
    protected $current_turn = null;

    /** @Column(type="datetime") */
    protected $created_at;

    /**
     * @var Player[]
     * @OneToMany(targetEntity="Main\Model\Player", mappedBy="game", cascade={"all"})
     * @OrderBy({"position" = "ASC", "id" = "ASC"})
     **/
    protected $players;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param  string $name
     * @return Game
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getCurrentStatus()
    {
        return $this->current_status;
    }

    /**
     * @param  int $current_status
     * @return Game
     */
    public function setCurrentStatus($current_status)
    {
        $this->current_status = $current_status;
        return $this;
    }

    /**
     * @return int
     */
    public function getMaxPlayers()
    {
        return $this->max_players;
    }

    /**
     * @return int
     */
    public function getNumberOfPlayers()
    {
        return count($this->players);
    }

    /**
     * @param  int $max_players
     * @return Game
     */
    public function setMaxPlayers($max_players)
    {
        $this->max_players = $max_players;
        return $this;
    }

    /**
     * @return array
     */
    public function toUrl()
    {
        return [
            'id' => $this->id(),
            'route' => 'game',
        ];
    }

    /**
     * @param  User $user
     * @return Player
     */
    public function joinUser(User $user)
    {
        if ($this->isPlayer($user)) {
            throw new Game\Exception('This user is already a player in the game.', Game\Exception::USER_ALREADY_JOINED);
        }

        if ($this->current_status != self::STATUS_WAITING) {
            throw new Game\Exception('You can only join to a game with WAITING status.', Game\Exception::GAME_ALREADY_LAUNCHED);
        }

        if ($this->getMaxPlayers() <= count($this->getPlayers())) {
            throw new Game\Exception('Maximum number of players reached.', Game\Exception::MAX_PLAYERS_REACHED);
        }

        $player = new Player([ 'user' => $user, ]);
        $this->addToPlayers($player);
        return $player;
    }

    /**
     * @param  Player $player
     * @return $this
     */
    public function addToPlayers($player)
    {
        $this->_addTo('players', $player, true);
        return $this;
    }

    /**
     * @param  User $user
     * @return $this
     */
    public function removeUser(User $user)
    {
        $player = $this->getPlayerByUser($user);
        if (empty($player)) {
            throw new Game\Exception('This user is not a player in the game.', Game\Exception::USER_IS_NOT_PLAYER);
        }

        if ($this->current_status != self::STATUS_WAITING) {
            throw new Game\Exception('You can only remove players from a game with WAITING status.', Game\Exception::GAME_ALREADY_LAUNCHED);
        }

        $this->delFromPlayers($player);
        $player->destroy();
        return $this;
    }

    /**
     * @param  Player $player
     * @return $this
     */
    public function delFromPlayers($player)
    {
        $this->_delFrom('players', $player);
        return $this;
    }

    /**
     * @return int
     */
    public function getNextAvailablePosition()
    {
        $position = 0;
        foreach ($this->getPlayers() as $player) {
            $position = max($position, $player->getPosition()) + 1;
        }

        return $position;
    }

    /**
     * @param  User $user
     * @return Player|null
     */
    public function getPlayerByUser(User $user = null)
    {
        foreach ($this->getPlayers() as $player) {
            if ($player->getUser() === $user) {
                return $player;
            }
        }

        return null;
    }

    /**
     * @param  User $user
     * @return bool
     */
    public function isPlayer(User $user = null)
    {
        return $this->getPlayerByUser($user) instanceof Player;
    }

    /**
     * @return Player[]|ArrayCollection
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * @return $this
     */
    public function restart()
    {
        if ($this->current_status != self::STATUS_STARTED) {
            throw new Game\Exception('You can only start a game with STARTED status.', Game\Exception::GAME_NOT_LAUNCHED);
        }

        $this->setCurrentStatus(self::STATUS_WAITING);

        $users = [];
        foreach ($this->getPlayers() as $player) {
            $users[] = $player->getUser();
            $this->removeUser($player->getUser());
        }

        foreach ($users as $user) {
            $this->joinUser($user);
        }

        $this->start();
        return $this;
    }

    /**
     * @return $this
     */
    public function start()
    {
        if ($this->current_status != self::STATUS_WAITING) {
            throw new Game\Exception('You can only start a game with WAITING status.', Game\Exception::GAME_ALREADY_LAUNCHED);
        }

        $this->current_turn = 1;
        foreach ($this->getPlayers() as $player) {

            $player->setTechnologies([ new Technology\Gathering([ 'developed' => true ]) ]);
            $player->getSupplyByType(Supply\Food::class)->setAmount(6);
            $player->getSupplyByType(Supply\Wood::class)->setAmount(2);
            $player->getUnitByType(Unit\Warrior::class)->setAmount(1);
            $player->beginTurnPhase();

        }

        $this->current_status = self::STATUS_STARTED;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEndTurnReady()
    {
        foreach ($this->getPlayers() as $player) {
            if ($player->getCurrentPhase() != Player::PHASE_ENDTURN) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return bool
     */
    public function tryNextTurn()
    {
        if ($this->isEndTurnReady()) {
            try {

                $this->nextTurn();
                return true;

            }
            catch (Game\Exception $ex) {

                throw new RuntimeException($ex->getMessage(), 0, $ex);

            }
        }

        return false;
    }

    /**
     * @return $this
     */
    protected function nextTurn()
    {
        foreach ($this->getPlayers() as $player) {
            $player->beginTurnPhase();
        }

        $this->current_turn += 1;
        return $this;
    }

    /**
     * @return $this
     */
    public function finish()
    {
        if ($this->current_status != self::STATUS_STARTED) {
            throw new Game\Exception('You can only finish a game with STARTED status.', Game\Exception::GAME_NOT_LAUNCHED);
        }

        $this->current_status = self::STATUS_FINISHED;
        return $this;
    }

    /**
     * @return int
     */
    public function getCurrentTurn()
    {
        return $this->current_turn;
    }

    /**
     * @return Game\Repository|EntityRepository
     */
    public static function getRepository()
    {
        return parent::getRepository();
    }
}