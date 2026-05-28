<?php
namespace Main\Model\Player;

use Doctrine\ORM\Mapping as ORM;
use E4u\Exception\LogicException;
use Main\Model\Player;

/**
 * @ORM\Entity
 * @ORM\Table(name="players_supplies", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="player_type", columns={"player_id", "type"})})
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *      "food"     = "\Main\Model\Player\Supply\Food",
 *      "gold"     = "\Main\Model\Player\Supply\Gold",
 *      "stone"    = "\Main\Model\Player\Supply\Stone",
 *      "wood"     = "\Main\Model\Player\Supply\Wood",
 *      "science"  = "\Main\Model\Player\Supply\Science"
 * })
 */
abstract class Supply extends Asset
{
    /**
     * @var Player
     * @ORM\ManyToOne(targetEntity="Main\Model\Player", inversedBy="supplies")
     */
    protected $player;

    /**
     * @return int[]
     */
    abstract public function productionMap();

    /**
     * @return int
     */
    public function productionAmount()
    {
        return array_sum($this->productionMap());
    }

    /**
     * @return $this
     */
    public function produce()
    {
        $this->addAmount($this->productionAmount());
        return $this;
    }

    /**
     * @param  int $amount
     * @return $this
     */
    public function pay($amount)
    {
        $this->setAmount($this->amount - $amount);
        return $this;
    }

    /**
     * @param  int $amount
     * @return $this
     */
    public function spend($amount)
    {
        $this->setAmount(max(0, $this->amount - $amount));
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
            throw new LogicException(sprintf('Invalid supply type: %s.', $type));
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
        return sprintf('player.supply.%s.name', $this->getType());
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return sprintf('player.supply.%s.description', $this->getType());
    }
}