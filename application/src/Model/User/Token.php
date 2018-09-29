<?php
namespace Main\Model\User;
use Main\Model\User;

/**
 * @Entity
 * @Table(name="users_tokens", indexes={
 *     @index(name="user_hash", columns={"user_id", "type", "hash"})
 * })
 */
class Token extends \E4u\Model\Entity
{
    const AUTO_LOGIN = 'autologin',
        RESET_PASSWORD = 'reset_password',
        ACTIVATE_ACCOUNT = 'activate_account',
        ACTIVATE_NEWSLETTER = 'activate_newsletter';

    /**
     * @var User
     * @ManyToOne(targetEntity="Main\Model\User")
     */
    protected $user;

    /** @Column(type="string") */
    protected $type;

    /** @Column(type="string") */
    protected $hash;
    
    /** @Column(type="datetime") */
    protected $created_at;

    /** @Column(type="datetime", nullable=true) */
    protected $expires_at;

    /**
     * @var string
     */
    protected $value;

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);

        if (null === $this->value) {
            $this->generateValue();
        }
    }

    /**
     * @return bool
     */
    public function isExpired()
    {
        return !is_null($this->expires_at)
            && $this->expires_at < new \DateTime();
    }

    /**
     * @return $this
     */
    public function setExpired()
    {
        $this->expires_at = (new \DateTime())->modify('-1 year');
        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param  int $length
     * @return $this
     */
    private function generateValue($length = 20)
    {
        $this->value = bin2hex(openssl_random_pseudo_bytes($length));
        return $this;
    }

    /**
     * @return $this
     */
    public function generateHash()
    {
        $this->hash = md5($this->value);
        return $this;
    }
    
    /**
     * @return $this
     */
    public function save()
    {
        if (null == $this->hash) {
            $this->generateHash();
        }
        
        parent::save();
        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param  int|\Main\Model\User $user
     * @param  string $type
     * @param  string $value
     * @return Token
     */
    public static function findOneByUserTypeAndValue($user, $type, $value)
    {
        $hash = md5($value);

        $qb = self::getEM()->createQueryBuilder();
        $qb->select('t, u')
            ->from(Token::class, 't')
            ->join('t.user', 'u')
            ->where('t.user = ?1 AND t.type = ?2 AND t.hash = ?3')
            ->setParameter(1, $user)
            ->setParameter(2, $type)
            ->setParameter(3, $hash);
        $token = $qb->getQuery()->getOneOrNullResult();
        if (!empty($token) && !$token->isExpired()) {
            return $token;
        }

        return null;
    }

    public function __toString()
    {
        return $this->getValue();
    }
}