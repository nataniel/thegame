<?php
namespace Main\Model\Player\Event;

use Doctrine\ORM\Mapping as ORM;
use Main\Model\Player\Event;

/**
 * @ORM\Entity
 */
class GameOver extends Event
{
    /**
     * @param  int $option
     * @return $this
     */
    protected function doResolve($option)
    {
        // game over, can't do anything
        return $this;
    }
}