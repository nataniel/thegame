<?php
namespace Main\Model\User;

use Doctrine\ORM\Mapping as ORM;
use E4u\Model\Entity;
use Main\Model\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="users_profiles", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="profile_type", columns={"profile_id", "type"})})
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *      "google" = "\Main\Model\User\Profile\Google",
 *      "facebook" = "\Main\Model\User\Profile\Facebook",
 *      "twitter" = "\Main\Model\User\Profile\Twitter",
 *      "steam" = "\Main\Model\User\Profile\Steam"
 * })
 */
abstract class Profile extends Entity
{
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="Main\Model\User", inversedBy="profiles", cascade={"persist"})
     */
    protected $user;

    /** @ORM\Column(type="string") */
    protected $profile_id;

    /** @ORM\Column(type="datetime") */
    protected $created_at;

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getProfileId()
    {
        return $this->profile_id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        $meta = $this->getClassMetadata();
        return array_search(static::class, $meta->discriminatorMap);
    }

    public abstract function getTypeName();
}