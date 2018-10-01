<?php
namespace Main\Model\Game;

use E4u\Loader;
use Main\Model\Player;
use Main\Model\User;
use Main\Model\Game;

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
        $this->user->getPlayer()->destroy();
        $this->user->setPlayer(null);
        return $this;
    }

    /**
     * @return $this
     */
    public function save()
    {
        $em = Loader::getDoctrine();
        $em->transactional(function ($em) {
            $this->user->save();
        });

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
     * @return Player\Event|null
     */
    public function getCurrentEvent()
    {
        return $this->getPlayer()->getCurrentEvent();
    }

    private function checkForUnresolvedEvents()
    {
        if ($this->getPlayer()->hasUnresolvedEvent()) {
            throw new Game\Exception('Najpierw musisz rozpatrzyć aktualne wydarzenie.', Game\Exception::UNRESOLVED_EVENT_EXISTS);
        }
    }

    /**
     * @param  string $type
     * @return Player\Unit
     */
    public function recruit($type)
    {
        $this->checkForUnresolvedEvents();
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
        $this->checkForUnresolvedEvents();
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
        $this->checkForUnresolvedEvents();
        $technology = $this->getPlayer()->getTechnologyByType($type);
        $technology->setActive();
        return $technology;
    }

    /**
     * @return $this
     */
    public function endTurn()
    {
        $this->checkForUnresolvedEvents();
        $this->getPlayer()->productionPhase();
        return $this;
    }

    /**
     * @param  int $option
     * @return $this
     */
    public function resolve($option)
    {
        $event = $this->getCurrentEvent();
        $event->resolve($option);
        return $this;
    }
}