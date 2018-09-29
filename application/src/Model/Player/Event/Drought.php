<?php
namespace Main\Model\Player\Event;

use Main\Model\Player\Event;
use Main\Model\Player\Supply;

/**
 * @Entity
 */
class Drought extends Event
{
    protected function doProcess()
    {
        $this->addToResult(Supply\Food::class, -1);
        return $this;
    }

    public function getImage()
    {
        return 'http://i.huffpost.com/gen/1998776/images/o-DROUGHT-facebook.jpg';
    }
}