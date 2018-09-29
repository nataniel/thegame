<?php
namespace Main\Model\Player;

use E4u\Exception\LogicException;
use E4u\Model\Entity;
use Main\Model\Player;
use Main\Model\Game;

/**
 * @Entity
 * @Table(name="players_technologies", uniqueConstraints={
 *     @UniqueConstraint(name="player_type", columns={"player_id", "type"}),
 *     @UniqueConstraint(name="player_active", columns={"player_id", "active"})
 * })
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="type", type="string")
 */
abstract class Technology extends Entity
{
    const PROGRESS_FULL = 100;
    const PRICE_SCIENCE = 2;

    /**
     * @var Player
     * @ManyToOne(targetEntity="Main\Model\Player", inversedBy="technologies", cascade={"persist"})
     */
    protected $player;

    /** @Column(type="integer", nullable=true) */
    protected $progress;

    /** @Column(type="boolean", nullable=true) */
    protected $active;

    /**
     * @return string[]
     */
    abstract public function availableAssets();

    /**
     * @return int
     */
    public function getPriceScience()
    {
        return static::PRICE_SCIENCE;
    }

    /**
     * @return string[]
     */
    public function requiredTechnologies()
    {
        return [];
    }

    /**
     * @return string[]
     */
    public function availableTechnologies()
    {
        $technologies = [];
        foreach ($this->availableAssets() as $assetClass) {
            if (is_a($assetClass, Technology::class, true)) {
                $technologies[] = $assetClass;
            }
        }

        return $technologies;
    }

    /**
     * @return bool
     */
    public function canBeDeveloped()
    {
        if (null === $this->getPlayer()) {
            return false;
        }

        foreach ($this->requiredTechnologies() as $technology) {
            if (!$this->getPlayer()->hasDevelopedTechnology($technology)) {
                return false;
            }
        }

        return $this->getPlayer()->getAvailableTechnologies()->contains($this);
    }

    /**
     * @param  int $science
     * @return $this
     */
    public function addScience($science)
    {
        $price = $this->getPriceScience();
        $progress =  $science / $price * self::PROGRESS_FULL;

        $this->setProgress($this->progress + $progress);
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
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param  bool $active
     * @return $this
     */
    public function setActive($active = true)
    {
        if (!empty($this->getPlayer()) && $active) {

            if (!$this->canBeDeveloped()) {
                throw new Game\Exception(sprintf('You cannot develop %s.', $this->getType()));
            }

            $technology = $this->getPlayer()->getActiveTechnology();
            if (!empty($technology) && $technology->isActive()) {
                $technology->setActive(null);
            }

        }

        if (false === $active) {
            throw new LogicException('Technology::$active can only be set to TRUE or NULL.');
        }

        $this->active = $active;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDeveloped()
    {
        return $this->progress >= self::PROGRESS_FULL;
    }

    /**
     * @return $this
     */
    public function setDeveloped()
    {
        $this->progress = self::PROGRESS_FULL;
        return $this;
    }

    /**
     * @param  int $progress
     * @return $this
     */
    protected function setProgress($progress)
    {
        if ($progress < 0) {
            throw new Game\Exception(sprintf('Progress of technology can not be set to a negative value.', $this->getType()));
        }

        if ($progress >= self::PROGRESS_FULL) {
            $this->setDeveloped();
        }

        $this->progress = $progress;
        return $this;
    }

    /**
     * @return int
     */
    public function getProgress()
    {
        return $this->progress;
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
    public function getName()
    {
        return sprintf('player.technology.%s.name', $this->getType());
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return sprintf('player.technology.%s.description', $this->getType());
    }

    /**
     * @param  string $type
     * @return string
     */
    public static function getClassFromType($type)
    {
        $meta = self::getEM()->getClassMetadata(self::class);
        if (!isset($meta->discriminatorMap[ $type ])) {
            throw new LogicException(sprintf('Invalid technology type: %s.', $type));
        }

        return $meta->discriminatorMap[ $type ];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}