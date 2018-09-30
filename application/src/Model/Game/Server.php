<?php
namespace Main\Model\Game;

use Main\Model\Player;
use Main\Model\User;

class Server
{
    /** @var User */
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return $this
     */
    public function resetGame()
    {
        $this->destroyPlayer();
        $this->createPlayer();

        return $this;
    }

    /**
     * @return $this
     */
    public function createPlayer()
    {
        $this->user->setPlayer(new Player());
        return $this;
    }

    /**
     * @return $this
     */
    public function destroyPlayer()
    {
        $this->user->setPlayer(null);
        return $this;
    }

    /**
     * @return $this
     */
    public function save()
    {
        $this->user->save();
        return $this;
    }

    /**
     * @return Player
     */
    public function getPlayer()
    {
        return $this->user->getPlayer();
    }

    /**
     * @param  string $type
     * @return Player\Unit
     */
    public function recruit($type)
    {
        $unit = $this->getPlayer()->getUnitByType($type);
        $unit->recruit();
        return $unit;
    }

    /**
     * @param  string $type
     * @return Player\Building
     */
    public function build($type)
    {
        $building = $this->getPlayer()->getBuildingByType($type);
        $building->build();
        return $building;
    }

    /**
     * @param  string $type
     * @return Player\Technology
     */
    public function develop($type)
    {
        $technology = $this->getPlayer()->getTechnologyByType($type);
        $technology->setActive();
        return $technology;
    }

    /**
     * @return $this
     */
    public function endTurn()
    {
        $this->getPlayer()->productionPhase();
        return $this;
    }
}