<?php
namespace Main\Model\User\Profile;

/**
 * @Entity
 */
class Steam extends \Main\Model\User\Profile
{
    public function getTypeName()
    {
        return "Steam Community";
    }
}