<?php
namespace Main\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use E4u\Model\Entity;
use Main\Model\Game;

use Main\Model\Player\Asset,
    Main\Model\Player\Technology,
    Main\Model\Player\Unit,
    Main\Model\Player\Building,
    Main\Model\Player\Supply,
    Main\Model\Player\Event;

/**
 * @Entity
 * @Table(name="players")
 */
class Player extends Entity
{
    /**
     * @var User
     * @OneToOne(targetEntity="Main\Model\User", inversedBy="player")
     */
    protected $user;

    /** @Column(type="integer") */
    protected $current_turn = 1;

    /** @Column(type="datetime") */
    protected $created_at;

    /**
     * @var Unit[]
     * @OneToMany(targetEntity="Main\Model\Player\Unit", mappedBy="player", cascade={"all"})
     * @OrderBy({"id" = "ASC"})
     **/
    protected $units;

    /**
     * @var Building[]
     * @OneToMany(targetEntity="Main\Model\Player\Building", mappedBy="player", cascade={"all"})
     * @OrderBy({"id" = "ASC"})
     **/
    protected $buildings;

    /**
     * @var Supply[]
     * @OneToMany(targetEntity="Main\Model\Player\Supply", mappedBy="player", cascade={"all"})
     * @OrderBy({"id" = "ASC"})
     **/
    protected $supplies;

    /**
     * @var Technology[]
     * @OneToMany(targetEntity="Main\Model\Player\Technology", mappedBy="player", cascade={"all"})
     * @OrderBy({"id" = "ASC"})
     **/
    protected $technologies;

    /**
     * @var Event[]
     * @OneToMany(targetEntity="Main\Model\Player\Event", mappedBy="player", cascade={"all"})
     * @OrderBy({"turn" = "ASC"})
     **/
    protected $events;

    public function __construct($attributes = [])
    {
        if ($attributes instanceof User) {
            $attributes = [ 'user' => $attributes ];
        }

        parent::__construct($attributes);
        $this->initAssets();
    }

    /**
     * @return $this
     */
    protected function initAssets()
    {
        $this->setTechnologies([ new Technology\Gathering([ 'developed' => true ]) ]);
        $this->getSupplyByType(Supply\Food::class)->setAmount(Supply\Food::STARTING_AMOUNT);
        $this->getSupplyByType(Supply\Wood::class)->setAmount(Supply\Wood::STARTING_AMOUNT);
        $this->getUnitByType(Unit\Warrior::class)->setAmount(Unit\Warrior::STARTING_AMOUNT);
        return $this;
    }

    /**
     * @return $this
     */
    public function reset()
    {
        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return int
     */
    public function getCurrentTurn()
    {
        return $this->current_turn;
    }

    /**
     * @return Unit[]
     */
    protected function getUnits()
    {
        return $this->units;
    }

    /**
     * @return Building[]
     */
    protected function getBuildings()
    {
        return $this->buildings;
    }

    /**
     * @return Supply[]
     */
    protected function getSupplies()
    {
        return $this->supplies;
    }

    /**
     * @return Technology[]|ArrayCollection
     */
    protected function getTechnologies()
    {
        return $this->technologies;
    }

    /**
     * @param  Technology[] $technologies
     * @return $this
     */
    public function setTechnologies($technologies)
    {
        $this->_set('technologies', $technologies, true);
        return $this;
    }

    /**
     * @return Technology[]|ArrayCollection
     */
    public function getDevelopedTechnologies()
    {
        $technologies = new ArrayCollection();
        foreach ($this->getTechnologies() as $technology) {
            if ($technology->isDeveloped()) {
                $technologies[] = $technology;
            }
        }

        return $technologies;
    }

    /**
     * @return Technology|null
     */
    public function getActiveTechnology()
    {
        foreach ($this->getTechnologies() as $technology) {
            if ($technology->isActive()) {
                return $technology;
            }
        }

        foreach ($this->getAvailableTechnologies() as $technology) {
            if ($technology->canBeDeveloped()) {
                return $technology;
            }
        }

        return null;
    }

    /**
     * @return string[]
     */
    protected function getAvailableAssetTypes()
    {
        $assets = [];
        foreach ($this->getDevelopedTechnologies() as $technology) {
            $assets = array_merge($assets, $technology->availableAssets());
        }

        return array_unique($assets);
    }

    /**
     * @return Supply[]|ArrayCollection
     */
    public function getAvailableSupplies()
    {
        $supplies = new ArrayCollection();
        foreach ($this->getAvailableAssetTypes() as $type) {
            if (is_a($type, Supply::class, true)) {
                $supplies[] = $this->getSupplyByType($type);
            }
        }

        return $supplies;
    }

    /**
     * @return Unit[]|ArrayCollection
     */
    public function getAvailableUnits()
    {
        $units = new ArrayCollection();
        foreach ($this->getAvailableAssetTypes() as $type) {
            if (is_a($type, Unit::class, true)) {
                $units[] = $this->getUnitByType($type);
            }
        }

        return $units;
    }

    /**
     * @return Building[]|ArrayCollection
     */
    public function getAvailableBuildings()
    {
        $buildings = new ArrayCollection();
        foreach ($this->getAvailableAssetTypes() as $type) {
            if (is_a($type, Building::class, true)) {
                $buildings[] = $this->getBuildingByType($type);
            }
        }

        return $buildings;
    }

    /**
     * @return Technology[]|ArrayCollection
     */
    public function getAvailableTechnologies()
    {
        $technologies = new ArrayCollection();
        foreach ($this->getAvailableAssetTypes() as $type) {
            if (is_a($type, Technology::class, true)) {
                $technology = $this->getTechnologyByType($type);
                if (!$technology->isDeveloped()) {
                    $technologies[] = $technology;
                }
            }
        }

        return $technologies;
    }

    /**
     * @param  string $class
     * @return Asset|Technology
     */
    public function getAssetByClass($class)
    {
        if (is_a($class, Unit::class, true)) {
            return $this->getUnitByType($class);
        }

        if (is_a($class, Building::class, true)) {
            return $this->getBuildingByType($class);
        }

        if (is_a($class, Supply::class, true)) {
            return $this->getSupplyByType($class);
        }

        if (is_a($class, Technology::class, true)) {
            return $this->getTechnologyByType($class);
        }

        throw new Game\Exception(sprintf('Invalid asset / technology classname: %s.', $class));
    }

    /**
     * @param  string $type
     * @return Unit
     */
    public function getUnitByType($type)
    {
        if (strpos($type, '\\') === false) {
            $type = Unit::getClassFromType($type);
        }

        foreach ($this->units as $unit) {
            if ($unit instanceof $type) {
                return $unit;
            }
        }

        return new $type([
            'player' => $this,
        ]);
    }

    /**
     * @param  string $type
     * @return Building
     */
    public function getBuildingByType($type)
    {
        if (strpos($type, '\\') === false) {
            $type = Building::getClassFromType($type);
        }

        foreach ($this->buildings as $building) {
            if ($building instanceof $type) {
                return $building;
            }
        }

        return new $type([
            'player' => $this,
        ]);
    }

    /**
     * @param  string $type
     * @return Supply
     */
    public function getSupplyByType($type)
    {
        if (strpos($type, '\\') === false) {
            $type = Supply::getClassFromType($type);
        }

        foreach ($this->supplies as $supply) {
            if ($supply instanceof $type) {
                return $supply;
            }
        }

        return new $type([
            'player' => $this,
        ]);
    }

    /**
     * @param  string $type
     * @return Technology
     */
    public function getTechnologyByType($type)
    {
        if (strpos($type, '\\') === false) {
            $type = Technology::getClassFromType($type);
        }

        foreach ($this->technologies as $technology) {
            if ($technology instanceof $type) {
                return $technology;
            }
        }

        return new $type([
            'player' => $this,
        ]);
    }

    /**
     * @param  int[] $supplies
     * @return bool
     */
    public function canAfford($supplies)
    {
        foreach ($supplies as $type => $amount) {
            $supply = $this->getSupplyByType($type);
            if ($amount > $supply->getAmount()) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param  string|Technology $type
     * @return bool
     */
    public function hasDevelopedTechnology($type)
    {
        foreach ($this->getDevelopedTechnologies() as $technology) {
            if ($technology instanceof $type) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param  int[] $supplies
     * @return $this
     */
    public function paySupplies($supplies)
    {
        foreach ($supplies as $type => $amount) {
            $supply = $this->getSupplyByType($type);
            $supply->pay($amount);
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getTotalStrength()
    {
        $strength = 0;
        foreach ($this->getAvailableUnits() as $unit) {
            $strength += $unit->getStrength() * $unit->getAmount();
        }

        return $strength;
    }

    /**
     * @return int
     */
    public function getBuildingLimit()
    {
        return 2 + $this->hasDevelopedTechnology(Technology\Architecture::class) * Technology\Architecture::LIMIT_BUILDINGS;
    }

    /**
     * @return $this
     */
    public function productionPhase()
    {
        $em = self::getEM();
        $em->transactional(function ($em) {
            $this->produceSupplies();
            $this->developActiveTechnology();
            $this->setNextTurn();
        });

        return $this;
    }

    /**
     * @return $this
     */
    public function eventResolutionPhase()
    {
        $em = self::getEM();
        $em->transactional(function ($em) {
            if ($this->changeCurrentPhase(self::PHASE_EVENTRESOLUTION, self::PHASE_PRODUCTION)) {

                // no event on 1st turn
                if ($this->game->getCurrentTurn() > 1) {
                    $event = Event::createRandomEventFor($this);
                    $event->process()->apply();
                }
            }
        });

        return $this;
    }

    /**
     * @return $this
     */
    private function produceSupplies()
    {
        foreach ($this->getAvailableSupplies() as $supply) {
            $supply->produce();
        }

        return $this;
    }

    /**
     * @return $this
     */
    private function developActiveTechnology()
    {
        $technology = $this->getActiveTechnology();
        if (empty($technology) || $technology->isDeveloped()) {
            throw new Game\Exception('Wybierz technologię do rozwoju.');
        }

        $science = $this->getSupplyByType(Supply\Science::class)->productionAmount();
        $technology->setActive()->addScience($science);

        if ($technology->isDeveloped()) {
            $technology->setActive(null);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function setNextTurn()
    {
        $this->current_turn += 1;
        return $this;
    }

    /**
     * @param  string $supplyClass
     * @return int
     */
    public function getProductionAmountOf($supplyClass)
    {
        return $this->getSupplyByType($supplyClass)->productionAmount();
    }

    /**
     * @return Event|null
     */
    public function getCurrentEvent()
    {
        $turn = $this->game->getCurrentTurn();
        foreach ($this->events as $event) {
            if ($event->getTurn() == $turn) {
                return $event;
            }
        }

        return null;
    }

    /**
     * @return Player\Event[]
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param  User $user
     * @return null|Player
     */
    public static function findByUser(User $user)
    {
        /** @var Player $player */
        $player = self::getRepository()->findOneBy([ 'user' => $user ]);
        return $player;
    }
}