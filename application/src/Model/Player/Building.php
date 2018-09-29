<?php
namespace Main\Model\Player;

use E4u\Exception\LogicException;
use Main\Model\Player;
use Main\Model\Game;

/**
 * @Entity
 * @Table(name="players_buildings", uniqueConstraints={
 *      @UniqueConstraint(name="player_type", columns={"player_id", "type"})})
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="type", type="string")
 * @DiscriminatorMap({
 *      "barracks" = "\Main\Model\Player\Building\Barracks",
 *      "farm" = "\Main\Model\Player\Building\Farm",
 *      "forester" = "\Main\Model\Player\Building\Forester",
 *      "library" = "\Main\Model\Player\Building\Library",
 *      "mine" = "\Main\Model\Player\Building\Mine",
 *      "monastery" = "\Main\Model\Player\Building\Monastery"
 * })
 */
abstract class Building extends Asset
{
    /**
     * @var Player
     * @ManyToOne(targetEntity="Main\Model\Player", inversedBy="buildings", cascade={"persist"})
     */
    protected $player;

    /**
     * @param  int $amount
     * @return int[]
     */
    public abstract function getPrice($amount = 1);

    /**
     * @param  int $amount
     * @return bool
     */
    public function canBeBuilt($amount = 1)
    {
        if (null === $this->player) {
            return false;
        }

        if (!$this->player->canAfford($this->getPrice($amount))) {
            return false;
        }

        if ($this->amount + $amount > $this->player->getBuildingLimit()) {
            return false;
        }

        return true;
    }

    /**
     * @param  int $amount
     * @return $this
     */
    public function build($amount = 1)
    {
        if (!$this->canBeBuilt($amount)) {
            throw new Game\Exception(sprintf('You cannot build %d of %s.', $amount, $this->getType()));
        }

        $this->addAmount($amount);
        $this->player->paySupplies($this->getPrice($amount));
        return $this;
    }

    /**
     * @param  int $amount
     * @return $this
     */
    public function setAmount($amount)
    {
        if (!empty($this->player)) {

            $max = $this->player->getBuildingLimit();
            if ($amount > $max) {
                throw new Game\Exception(sprintf('The player can only have %d of each building.', $max));
            }

        }

        parent::setAmount($amount);
        return $this;
    }

    /**
     * @param  string $type
     * @return string
     */
    public static function getClassFromType($type)
    {
        $meta = self::getEM()->getClassMetadata(self::class);
        if (!isset($meta->discriminatorMap[ $type ])) {
            throw new LogicException(sprintf('Invalid building type: %s.', $type));
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

    /**
     * @return string
     */
    public function getName()
    {
        return sprintf('player.building.%s.name', $this->getType());
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return sprintf('player.building.%s.description', $this->getType());
    }
}