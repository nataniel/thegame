<?php
namespace Main\Model\Player\Event;

use Main\Model\Player\Event;

/**
 * @Entity
 */
class Nothing extends Event
{
    protected function doInitialize()
    {
        $this->setResolved();
        return $this;
    }

    protected function doResolve($option)
    {
        return $this;
    }

    public function getImage()
    {
        return '//i.ytimg.com/vi/SrydkUYUoYo/maxresdefault.jpg';
    }

}