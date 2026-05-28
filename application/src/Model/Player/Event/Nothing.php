<?php
namespace Main\Model\Player\Event;

use Doctrine\ORM\Mapping as ORM;
use Main\Model\Player\Event;

/**
 * @ORM\Entity
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