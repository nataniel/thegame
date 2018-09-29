<?php
namespace Main\Model\Player;

use E4u\Model\Entity;
use Main\Model\Player;
use Main\Model\Game;

/**
 * @MappedSuperclass
 */
abstract class Asset extends Entity
{
    /**
     * @var Player
     */
    protected $player;

    /** @Column(type="integer") */
    protected $amount = 0;

    /**
     * @return Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param  int $amount
     * @return $this
     */
    public function addAmount($amount = 1)
    {
        $this->setAmount($this->amount + $amount);
        return $this;
    }

    /**
     * @param  int $amount
     * @return $this
     */
    public function setAmount($amount)
    {
        if ($amount < 0) {
            throw new Game\Exception(sprintf('Amount of %s can not be set to a negative value.', $this->getType()));
        }

        $this->amount = $amount;
        return $this;
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
     * @param  int[] $input
     * @return int[]
     */
    protected function buildMap($input)
    {
        if (empty($this->player)) {
            return [];
        }

        $map = [];
        foreach ($input as $class => $amount) {
            if (is_a($class, Technology::class, true)) {
                $map[ $class ] = $this->player->hasDevelopedTechnology($class) * $amount;
            }

            if (is_a($class, Asset::class, true)) {
                $map[ $class ] = $this->player->getAssetByClass($class)->getAmount() * $amount;
            }
        }

        return array_filter($map);
    }
}