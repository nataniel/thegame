<?php
namespace Main\Model\User;

use Doctrine\ORM\Mapping as ORM;
use E4u\Model\Entity;
use Main\Model\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="users_properties")
 */
class Property extends Entity
{
    const AVATAR = 'avatar';

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="Main\Model\User", inversedBy="properties")
     */
    protected $user;

    /** @ORM\Column(type="string") */
    protected $name;

    /** @ORM\Column(type="text") */
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
     * @return Property
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