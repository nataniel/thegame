<?php
namespace Main\Model\Player\Event;

use Main\Model\Player\Event;

/**
 * @Entity
 */
class GameOver extends Event
{
    protected function doInitialize()
    {
        return $this;
    }

    /**
     * @param  int $option
     * @return $this
     */
    protected function doResolve($option)
    {
        // game over, can't do anything
        return $this;
    }

    public function getImage()
    {
        return '//lurkmore.so/images/3/3d/Restinpeaceripgraveyard.jpg';
    }
}