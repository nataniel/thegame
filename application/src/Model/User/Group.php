<?php
namespace Main\Model\User;

use E4u\Model\Base;
use Main\Model\User;

/**
 * @Entity(readOnly=true)
 * @Table(name="users_groups")
 */
class Group extends Base
{
    const ADMINISTRATORZY = 1,
        ZAREJESTROWANI_UZYTKOWNICY = 2;

    /**
     * @var User
     * @Id @ManyToOne(targetEntity="Main\Model\User", inversedBy="groups")
     */
    protected $user;

    /** @Id @Column(type="integer") */
    protected $group_id;

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return int
     */
    public function id()
    {
        return $this->group_id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->group_id;
    }
}