<?php
namespace Main\Model\Player\Event;

use Main\Model\Player\Event;
use Main\Model\Player\Supply;

/**
 * @Entity
 */
class Drought extends Event
{
    protected function doInitialize()
    {
        $this->applyResult([ Supply\Food::class => -1 ]);
        return $this;
    }

    protected function doResolve($option)
    {
        $this->applyResult([ Supply\Food::class => -1 ]);
        $this->setFinished();
        return $this;
    }
}