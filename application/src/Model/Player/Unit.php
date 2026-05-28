<?php
namespace Main\Model\Player;

use Doctrine\ORM\Mapping as ORM;
use E4u\Exception\LogicException;
use Main\Model\Player;
use Main\Model\Game;

/**
 * @ORM\Entity
 * @ORM\Table(name="players_units", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="player_type", columns={"player_id", "type"})})
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *      "archer"  = "\Main\Model\Player\Unit\Archer",
 *      "cleric"  = "\Main\Model\Player\Unit\Cleric",
 *      "knight"  = "\Main\Model\Player\Unit\Knight",
 *      "warrior" = "\Main\Model\Player\Unit\Warrior"
 * })
 */
abstract class Unit extends Asset
{
    /**
     * @var Player
     * @ORM\ManyToOne(targetEntity="Main\Model\Player", inversedBy="units")
     */
    protected $player;

    /**
     * @param  int $amount
     * @return int[]
     */
    public abstract function getPrice($amount = 1);

    /**
     * @return int
     */
    public abstract function getUpkeep();

    /**
     * @return int
     */
    public abstract function getStrength();

    /**
     * @return int
     */
    public abstract function getRange();

    /**
     * @return int
     */
    public abstract function getDefense();

    /**
     * @return int
     */
    public abstract function getSpeed();

    /**
     * @return int[]
     */
    public abstract function capacityMap();

    /**
     * @return int
     */
    public function maxAmount()
    {
        return array_sum($this->capacityMap());
    }

    /**
     * @param  int $amount
     * @return bool
     */
    public function canBeRecruited($amount = 1)
    {
        if (null === $this->player) {
            return false;
        }

        if ($this->amount + $amount > $this->maxAmount()) {
            return false;
        }

        if (!$this->player->canAfford($this->getPrice($amount))) {
            return false;
        }

        return true;
    }

    /**
     * @param  int $amount
     * @return $this
     */
    public function recruit($amount = 1)
    {
        if (!$this->canBeRecruited($amount)) {
            throw new Game\Exception(sprintf('You cannot recruit %d of %s.', $amount, $this->getType()));
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

            $max = $this->maxAmount();
            if ($amount > $max) {
                throw new Game\Exception(sprintf('The player can only have %d of %s.', $max, $this->getType()));
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
            throw new LogicException(sprintf('Invalid unit type: %s.', $type));
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
        return sprintf('player.unit.%s.name', $this->getType());
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return sprintf('player.unit.%s.description', $this->getType());
    }

    /**
     * @param  int $amount
     * @return int
     */
    protected function animalBreedingDiscount($amount)
    {
        return $this->player->hasDevelopedTechnology(Technology\AnimalBreeding::class)
            * Technology\AnimalBreeding::UNITS_DISCOUNT * $amount;
    }
}