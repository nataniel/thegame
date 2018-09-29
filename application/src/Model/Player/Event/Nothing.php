<?php
namespace Main\Model\Player\Event;

use Main\Model\Player\Event;

/**
 * @Entity
 */
class Nothing extends Event
{
    protected function doProcess()
    {
        return $this;
    }

    public function getImage()
    {
        return 'https://i.ytimg.com/vi/SrydkUYUoYo/maxresdefault.jpg';
    }

}