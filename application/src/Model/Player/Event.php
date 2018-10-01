<?php
namespace Main\Model\Player;

use E4u\Model\Entity;
use Main\Model\Game;
use Main\Model\Player;

/**
 * @Entity
 * @Table(name="players_events")
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="type", type="string")
 */
abstract class Event extends Entity
{
    const
        CREATED = 0,
        RESOLVED = 50,
        FINISHED = 100;

    /**
     * @var Player
     * @ManyToOne(targetEntity="Main\Model\Player", inversedBy="events")
     */
    protected $player;

    /** @Column(type="integer", nullable=true) */
    protected $random_seed;

    /** @Column(type="integer") */
    protected $status = self::CREATED;

    /** @Column(type="datetime") */
    protected $created_at;

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->generateRandomSeed();
    }

    /**
     * @return $this
     */
    public function init()
    {
        $this->doInitialize();
        return $this;
    }

    /**
     * @return $this
     */
    protected function generateRandomSeed()
    {
        $this->random_seed = function_exists('random_int')
            ? random_int(0, 99999999)
            : rand(0, 99999999);
        return $this;
    }

    /**
     * @param  int $option
     * @return $this
     */
    public function resolve($option)
    {
        if ($this->isFinished()) {
            throw new Game\Exception('To wydarzenie zostało już rozwiązane.');
        }

        if ($this->isResolved()) {
            $this->setFinished();
            return $this;
        }

        srand($this->random_seed);
        $this->doResolve($option);
        return $this;
    }

    /**
     * @param  int $option
     * @return $this
     */
    abstract protected function doResolve($option);
    abstract protected function doInitialize();

    /**
     * @param  array $result
     * @return $this
     */
    public function applyResult($result = [])
    {
        foreach ($result as $class => $amount) {
            $asset = $this->player->getAssetByClass($class);
            if ($asset instanceof Player\Asset) {
                if ($asset->getAmount() + $amount < 0) {
                    $this->player->gameOver();
                    return $this;
            }

                $asset->addAmount($amount);
            }
        }

        $this->setResolved();
        return $this;
    }

    /**
     * @return Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * @return bool
     */
    public function isResolved()
    {
        return $this->status == self::RESOLVED;
    }

    /**
     * @return bool
     */
    public function isFinished()
    {
        return $this->status == self::FINISHED;
    }

    /**
     * @return $this
     */
    protected function setResolved()
    {
        $this->status = self::RESOLVED;
        return $this;
    }

    /**
     * @return $this
     */
    protected function setFinished()
    {
        $this->status = self::FINISHED;
        return $this;
    }

    /**
     * @param  int $status
     * @return bool
     */
    public function isStatus($status)
    {
        return $this->status == $status;
    }

    /**
     * @return string
     */
    public function getType()
    {
        $meta = $this->getClassMetadata();
        return array_search(static::class, $meta->discriminatorMap);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return sprintf('player.event.%s.name', $this->getType());
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return sprintf('player.event.%s.description', $this->getType());
    }

    /**
     * @return Event
     */
    public static function generateRandomEvent()
    {
        switch (rand(0,2)) {
            case 1:  return new Event\Drought();
            case 2:  return new Event\Raiders();
            default: return new Event\Nothing();
        }
    }
}