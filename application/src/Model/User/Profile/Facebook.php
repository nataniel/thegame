<?php
namespace Main\Model\User\Profile;

use Main\Model\User\Profile;

/**
 * @Entity
 */
class Facebook extends Profile
{
    public function getTypeName()
    {
        return "Facebook";
    }
}