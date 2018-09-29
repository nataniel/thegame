<?php
namespace Main\Model\User;

use E4u\Exception\LogicException;
use E4u\Mailer\Template;
use Main\Model\User;
use Main\Email;

class Registration
{
    /**
     * @var User
     */
    private $user;

    /**
     * @param User|null $user
     */
    public function __construct(User $user = null)
    {
        $this->user = $user;
    }

    /**
     * @param  array $values
     * @return $this
     */
    public function register($values)
    {
        if (!is_null($this->user)) {
            throw new LogicException('User is already registered.');
        }

        if (empty($values['email'])) {
            throw new Exception('Brak poprawnego adresu e-mail w danych rejestracji.',
                Exception::EMAIL_IS_REQUIRED);
        }

        $user = User::getRepository()->findOneByLogin($values['email']);
        if (empty($user)) {

            // tworzymy nowego uzytkownika
            $this->user = new User($values);

        }
        elseif (!$user->isActive()) {

            // aktualizujemy dane (tylko dla nieaktywnego uzytkownika)
            $this->user = $user->loadArray($values);

        }
        elseif ($user->hasPassword()) {

            throw new Exception('Taki użytkownik jest już zarejestrowany.
                Jeżeli nie pamiętasz hasła, <a href="%s">kliknij tutaj</a>, aby je odzyskać.',
                Exception::USER_ALREADY_REGISTERED);

        } else {

            throw new Exception('Ten adres e-mail jest już zarejestrowany.
                Jeżeli należy do Ciebie, <a href="%s">kliknij tutaj</a>, aby ustawić hasło do konta.',
                Exception::EMAIL_ALREADY_REGISTERED);

        }

        return $this;
    }

    /**
     * @param  string $value
     * @return $this
     */
    public function activate($value)
    {
        if (empty($value)) {
            throw new Exception('Nieprawidłowy token rejestracji.',
                Exception::INVALID_TOKEN);
        }

        if (empty($this->user)) {
            throw new Exception('Nieprawidłowy użytkownik.',
                Exception::INVALID_TOKEN);
        }

        $token = User\Token::findOneByUserTypeAndValue($this->user->id(), User\Token::ACTIVATE_ACCOUNT, $value);
        if (null === $token) {
            throw new Exception('Nieprawidłowy token rejestracji.',
                Exception::INVALID_TOKEN);
        }

        $this->user
            ->setActive(true);
        return $this;
    }

    /**
     * @param  string $interval
     * @return User\Token
     */
    public function getActivationToken($interval = '+7 day')
    {
        return new User\Token([
            'user' => $this->user,
            'type' => User\Token::ACTIVATE_ACCOUNT,
            'expires_at' => (new \DateTime())->modify($interval),
        ]);
    }

    /**
     * @param  string $url with %d to replace with user::id()
     * @return Template
     */
    public function getActivationEmail($url)
    {
        return new Email\Security\UserActivation([
            'user' => $this->user,
            'url' => sprintf($url, $this->user->id()),
        ]);
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}