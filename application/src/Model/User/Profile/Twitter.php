<?php
namespace Main\Model\User\Profile;

/**
 * @Entity
 */
class Twitter extends \Main\Model\User\Profile
{
    public function getTypeName()
    {
        return "Twitter";
    }
}