<?php
namespace Main\Model\Player\Event;

use Main\Model\Player\Event;

/**
 * @Entity
 */
class Nothing extends Event
{
    protected $status = self::RESOLVED;

    protected function doResolve($option)
    {
        $this->setFinished();
        return $this;
    }
}