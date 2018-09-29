<?php
namespace Main\Model\User\Profile;

/**
 * @Entity
 */
class Google extends \Main\Model\User\Profile
{
    public function getTypeName()
    {
        return "Google Account";
    }
}