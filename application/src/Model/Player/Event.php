<?php
//namespace Main\Model\Player;
//
//use E4u\Model\Entity;
//use E4u\Model\Exception;
//use Main\Model\Player;
//
///**
// * @Entity
// * @Table(name="players_events", uniqueConstraints={
// *      @UniqueConstraint(name="player_turn", columns={"player_id", "turn"})})
// * @InheritanceType("SINGLE_TABLE")
// * @DiscriminatorColumn(name="type", type="string")
// */
//abstract class Event extends Entity
//{
//    /**
//     * @var Player
//     * @ManyToOne(targetEntity="Main\Model\Player", inversedBy="events")
//     */
//    protected $player;
//
//    /** @Column(type="integer") */
//    protected $random_seed;
//
//    /** @Column(type="integer") */
//    protected $turn;
//
//    /** @Column(type="boolean") */
//    protected $is_resolved = false;
//
//    /** @Column(type="datetime") */
//    protected $created_at;
//
//    /**
//     * @var int[]
//     */
//    protected $result = [];
//
//    /**
//     * @return int
//     */
//    protected function getRandomSeed()
//    {
//        if (null === $this->random_seed) {
//
//            $this->random_seed = function_exists('random_int')
//                ? random_int(0, 99999999)
//                : rand(0, 99999999);
//        }
//
//        return $this->random_seed;
//    }
//
//    /**
//     * @return $this
//     */
//    public function process()
//    {
//        srand($this->getRandomSeed());
//        $this->resetResult();
//        $this->doProcess();
//        return $this;
//    }
//
//    /**
//     * @return $this
//     */
//    abstract protected function doProcess();
//
//    /**
//     * @return $this
//     */
//    public function  apply()
//    {
//        if ($this->isResolved()) {
//            throw new Exception('Event already resolved.');
//        }
//
//        foreach ($this->result as $class => $amount) {
//            $asset = $this->player->getAssetByClass($class);
//            if ($asset instanceof Player\Asset) {
//                $asset->addAmount($amount);
//            }
//        }
//
//        $this->setResolved();
//        return $this;
//    }
//
//    /**
//     * @param  string $class
//     * @param  int $amount
//     * @return $this
//     */
//    protected function addToResult($class, $amount)
//    {
//        if ($amount != 0) {
//            if (!isset($this->result[ $class ])) {
//                $this->result[ $class ] = $amount;
//            }
//            else {
//                $this->result[ $class ] += $amount;
//            }
//        }
//
//        return $this;
//    }
//
//    /**
//     * @return $this
//     */
//    protected function resetResult()
//    {
//        $this->result = [];
//        return $this;
//    }
//
//    /**
//     * @return int[]
//     */
//    public function getResult()
//    {
//        return $this->result;
//    }
//
//    /**
//     * @return Player
//     */
//    public function getPlayer()
//    {
//        return $this->player;
//    }
//
//    /**
//     * @return int
//     */
//    public function getTurn()
//    {
//        return $this->turn;
//    }
//
//    /**
//     * @return bool
//     */
//    public function isResolved()
//    {
//        return $this->is_resolved;
//    }
//
//    /**
//     * @param  bool $resolved
//     * @return $this
//     */
//    protected function setResolved($resolved = true)
//    {
//        $this->is_resolved = $resolved;
//        return $this;
//    }
//
//    /**
//     * @return string
//     */
//    public function getType()
//    {
//        $meta = $this->getClassMetadata();
//        return array_search(static::class, $meta->discriminatorMap);
//    }
//
//    /**
//     * @return string
//     */
//    public function __toString()
//    {
//        return $this->getName();
//    }
//
//    /**
//     * @return string
//     */
//    public function getName()
//    {
//        return sprintf('player.event.%s.name', $this->getType());
//    }
//
//    /**
//     * @return string
//     */
//    public function getDescription()
//    {
//        return sprintf('player.event.%s.description', $this->getType());
//    }
//
//    /**
//     * @param  Player $player
//     * @return Event
//     */
//    public static function createRandomEventFor(Player $player)
//    {
//        switch (rand(0,2)) {
//            case 1: $class = Player\Event\Drought::class; break;
//            case 2: $class = Player\Event\Barbarians::class; break;
//            default: $class = Player\Event\Nothing::class; break;
//        }
//
//        return new $class([
//            'player' => $player,
//            'turn' => $player->getGame()->getCurrentTurn(),
//        ]);
//    }
//}