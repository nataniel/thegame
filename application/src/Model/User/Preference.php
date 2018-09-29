<?php
namespace Main\Model\User;

use E4u\Model\Entity;
use Main\Model\User;

/**
 * @Entity
 * @Table(name="users_preferences")
 */
class Preference extends Entity
{
    const AVATAR = 'avatar';

    /**
     * @var User
     * @ManyToOne(targetEntity="Main\Model\User", inversedBy="preferences")
     */
    protected $user;

    /** @Column(type="string") */
    protected $name;

    /** @Column(type="text") */
    protected $value;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param  mixed $value
     * @return Preference
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    public function __toString()
    {
        return (string)$this->getValue();
    }
}