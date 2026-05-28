<?php
namespace Main\Model\User\Profile;

use Doctrine\ORM\Mapping as ORM;
use Main\Model\User\Profile;

/**
 * @ORM\Entity
 */
class Facebook extends Profile
{
    public function getTypeName()
    {
        return "Facebook";
    }
}