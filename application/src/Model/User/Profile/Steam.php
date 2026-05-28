<?php
namespace Main\Model\User\Profile;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Steam extends \Main\Model\User\Profile
{
    public function getTypeName()
    {
        return "Steam Community";
    }
}