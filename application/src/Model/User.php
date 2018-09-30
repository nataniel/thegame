<?php
namespace Main\Model;

use Doctrine\ORM\EntityRepository;
use E4u\Common\File\Image;
use E4u\Authentication\Identity\User as E4uUser;
use Main\Model\User\Privilege;
use Zend\Mail\Address\AddressInterface;

/**
 * @Entity(repositoryClass="Main\Model\User\Repository")
 * @Table(name="users")
 */
class User extends E4uUser implements AddressInterface
{
    /** @Column(type="string") */
    protected $first_name = '';

    /** @Column(type="string") */
    protected $last_name = '';

    /** @Column(type="string", nullable=true) */
    protected $locale = 'pl';

    /**
     * @var User\Profile[]
     * @OneToMany(targetEntity="Main\Model\User\Profile", mappedBy="user", cascade={"all"}, orphanRemoval=true)
     **/
    protected $profiles;

    /**
     * @var User\Property[]
     * @OneToMany(targetEntity="Main\Model\User\Property", mappedBy="user", cascade={"all"}, indexBy="name", orphanRemoval=true)
     * @OrderBy({"name" = "ASC"})
     **/
    protected $properties;

    /**
     * @var Player
     * @OneToOne(targetEntity="Main\Model\Player", mappedBy="user", cascade={"all"}, orphanRemoval=true)
     **/
    protected $player;

    /**
     * @param  string $email
     * @return $this
     */
    public function setEmail($email)
    {
        return $this->setLogin($email);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return ucwords(trim($this->first_name . ' ' . $this->last_name));
    }

    /**
     * @return string|null
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param  string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->first_name = strtok($name, ' ');
        $this->last_name = (string)strtok('');
        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Implements Identity
     * @param  int|bool $value
     * @return boolean
     */
    public function hasPrivilege($value)
    {
        if (true === $value) {
            return $this->isActive();
        }

        if (Privilege::ADMIN === $value) {
            return $this->id === 1;
        }

        return false;
    }

    /**
     * @param string $name
     * @param string $default
     * @return string
     */
    public function getProperty($name, $default = '')
    {
        return isset($this->properties[ $name ])
            ? (string)$this->properties[ $name ]
            : $default;
    }

    /**
     * @param  string $name
     * @param  string $value
     * @return $this
     */
    public function setProperty($name, $value)
    {
        if (isset($this->properties[ $name ])) {
            $this->properties[ $name ]->setValue($value);
        }
        else {
            $this->_addTo('properties', [
                'name' => $name,
                'value' => $value,
            ]);
        }

        return $this;
    }

    /**
     * @return User\Profile[]
     */
    public function getProfiles()
    {
        return $this->profiles;
    }

    /**
     * Implements Identity
     *
     * @param  string $cookie
     * @return User
     */
    public static function findByCookie($cookie)
    {
        $id = strtok($cookie, '/');
        $value = strtok('');

        $token = User\Token::findOneByUserTypeAndValue((int)$id, User\Token::AUTO_LOGIN, $value);
        if (null === $token) {
            return null;
        }

        $user = $token->getUser();
        $token->destroy();
        return $user;
    }

    /**
     * Implements Identity
     * @return string
     */
    public function getCookie()
    {
        $token = User\Token::create([
            'user' => $this,
            'type' => 'autologin',
            'expires_at' => (new \DateTime())->modify('+1 year'),
        ]);

        return $this->id() . '/' . $token->getValue();
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->login;
    }

    /**
     * @return User\Property[]
     */
    public function getProperties()
    {
        return $this->properties;
    }
    
    public function getFirstName()
    {
        return $this->first_name;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @return Image|null
     */
    public function getAvatar()
    {
        $avatar = $this->getProperty(User\Property::AVATAR);
        if (!empty($avatar)) {

            if (strpos($avatar, 'http://') === 0 ||
                strpos($avatar, 'https://') === 0 ||
                strpos($avatar, '//') === 0) {
                return new Image($avatar);
            }

        }

        return null;
    }

    /**
     * @param  string $avatar
     * @return $this
     */
    public function setAvatar($avatar)
    {
        $this->setProperty(User\Property::AVATAR, (string)$avatar);
        return $this;
    }

    /**
     * @param  string $login
     * @return bool
     */
    public static function loginExists($login)
    {
        $user = self::getRepository()->findOneByLogin($login);
        return !empty($user);
    }

    /**
     * @return User\Repository|EntityRepository
     */
    public static function getRepository()
    {
        return parent::getRepository();
    }

    /**
     * @return string
     */
    public function toUrl()
    {
        return '/users/show/' . $this->id;
    }

    /**
     * @param  User\Profile $profile
     * @param  bool $keepConsistency
     * @return $this
     */
    public function addToProfiles($profile, $keepConsistency = true)
    {
        $this->_addTo('profiles', $profile, $keepConsistency);
        return $this;
    }

    /**
     * @return bool
     */
    public function hasPassword()
    {
        return !empty($this->encrypted_password);
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->getEmail();
    }

    /**
     * @return Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * @param  Player $player
     * @param  bool $keepConsistency
     * @return $this
     */
    public function setPlayer($player, $keepConsistency = true)
    {
        $this->_set('player', $player, $keepConsistency);
        return $this;
    }
}