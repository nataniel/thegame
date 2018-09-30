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
        $this->setFinished();
        return $this;
    }

    public function getImage()
    {
        return '//i.huffpost.com/gen/1998776/images/o-DROUGHT-facebook.jpg';
    }
}