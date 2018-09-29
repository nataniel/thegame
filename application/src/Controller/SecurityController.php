<?php
namespace Main\Controller;

use E4u\Application\Controller\Security as E4uSecurity,
    E4u\Authentication\Exception,
    E4u\Application\View,
    E4u\Response,
    Main\Form\Security as Forms,
    Main\Model\User,
    Main\Email;

class SecurityController extends AbstractController implements E4uSecurity
{
    protected $requiredPrivileges = [ ];
    protected $defaultLayout = 'layout/security';

    public function indexAction()
    {
        return $this->redirectTo('/security/login');
    }

    public function loginAction()
    {
        $loginForm = $this->loginForm();
        $passwordForm = $this->passwordForm();

        return [
            'title' => 'Zaloguj się',
            'passwordForm' => $passwordForm,
            'loginForm' => $loginForm,
        ];
    }

    public function logoutAction()
    {
        $this->getAuthentication()->logout();
        return $this->redirectTo('/',
            "Zostałeś wylogowany.",
            View::FLASH_SUCCESS);
    }

    public function registerAction()
    {
        $form = new Forms\Register($this->getRequest());
        if ($form->isValid()) {

            $values = $form->getValues();
            try {

                $registration = new User\Registration();
                $registration->register([
                    'name' => $values['name'],
                    'email' => $values['email'],
                    'password' => $values['password'],
                    'active' => false,
                ]);

                $user = $registration->getUser();
                $user->save();

                $token = $registration->getActivationToken();
                $token->save();

                $template = $registration->getActivationEmail($this->urlTo('/security/activate/%d?token=' . $token, true));
                $template->send();

                return $this->redirectTo('/security/login', 'Na Twój adres e-mail
                    została wysłana wiadomość. <strong>Kliknij link znajdujący się w wiadomości</strong>, aby potwiedzić rejestrację.
                    Jeżeli e-mail nie dotrze w ciągu 10 minut, <a href="mailto:support@rebel.pl">skontaktuj się z nami</a>.', View::FLASH_SUCCESS);

            }
            catch (User\Exception $e) {

                $form->addError(sprintf($e->getMessage(), $this->urlTo('/security/password?login=' . $values['email'])));

            }

        }

        return [
            'title' => 'Rejestracja konta',
            'form' => $form,
        ];
    }

    public function activateAction()
    {
        $user = $this->getUserFromParam();
        $value = $this->getRequest()->getQuery('token');

        try {

            $registration = new User\Registration($user);
            $registration->activate($value);
            $user->save();

            return $this->redirectBackOrTo('/security/login',
                '<strong>Konto zostało aktywowane</strong>, teraz możesz się na nie zalogować.',
                View::FLASH_SUCCESS);

        }
        catch (User\Exception $e) {

            return $this->redirectBackOrTo('/security/login',
                $e->getMessage(),
                View::FLASH_ERROR);

        }

    }

    public function passwordAction()
    {
        $form = new Forms\Password($this->getRequest());
        $form->setDefaults([ 'login' => $this->getRequest()->getQuery('login') ]);

        if ($form->isValid()) {
            $login = $form->getValue('login');
            $user = User::getRepository()->findOneByLogin($login);
            if (!empty($user)) {
                $this->sendForgotPassword($user);
            }

            return $this->redirectTo('/security/login', 'Na adres użytkownika
                    <strong>została wysłana wiadomość</strong> z instrukcją dot. zmiany hasła.
                    Jeżeli e-mail nie dotrze w ciągu 10 minut, <a href="mailto:support@xpect.pl">skontaktuj się z nami</a>.', View::FLASH_SUCCESS);
        }

        return [
            'form' => $form,
        ];
    }

    public function resetAction()
    {
        $user = $this->getUserFromParam();
        $this->verifyToken($user, User\Token::RESET_PASSWORD);

        $form = new Forms\Reset($this->getRequest());
        $form->getElement('login')->setValue($user->getLogin() ?: $user->getEmail());

        if ($form->isValid()) {
            $user->setPassword($form->getValue('password'))->save();
            return $this->redirectTo('security/login',
                '<strong>Hasło zostało zmienione</strong>. Zaloguj się, używając nowego hasła.',
                View::FLASH_SUCCESS);
        }

        return [
            'form' => $form,
            'title' => 'Nowe hasło',
            'user' => $user,
        ];
    }

    /**
     * @return User|Response\Redirect
     */
    private function getUserFromParam()
    {
        $id = (int)$this->getParam('id');
        if (empty($id)) {
            return $this->redirectTo('/', 'Nieprawidłowy identyfikator użytkownika.', View::FLASH_ERROR);
        }

        $user = User::find($id);
        if (null === $user) {
            return $this->redirectTo('/', 'Nieprawidłowy identyfikator użytkownika.', View::FLASH_ERROR);
        }

        return $user;
    }

    private function loginSuccess(User $user)
    {
        $message = sprintf(
            'Zalogowano jako <strong>%s</strong> (%s).',
            $user->getName(), $user->getLogin() ?: $user->getEmail());
        return $this->redirectBackOrTo('/', $message, View::FLASH_SUCCESS);
    }

    private function loginForm()
    {
        $form = new \Main\Form\Security\Login($this->getRequest());

        if ($form->isValid()) {
            $values = $form->getValues();
            try {

                /** @var User $user */
                $user = $this->getAuthentication()->login($values['email'], $values['password'], $values['remember']);
                return $this->loginSuccess($user);

            }
            catch (Exception\UserNotActiveException $e) {
                $form->addError('Użytkownik jest nieaktywny. <strong>Skontaktuj się z działem obsługi klienta</strong>, aby aktywować konto.', 'password');
            }
            catch (Exception\AuthenticationException $e) {
                $form->addError('Nieprawidłowa nazwa użytkownika lub hasło.', 'password');
            }
        }

        return $form;
    }

    /**
     * @return \Main\Form\Security\Password
     * @throws \E4u\Application\Controller\Redirect
     */
    private function passwordForm()
    {
        $form = new \Main\Form\Security\Password($this->getRequest());
        if ($form->isValid()) {
            $user = User::getRepository()->findOneByLogin($form->getValue('login'));
            if (!empty($user)) {

                $this->sendForgotPassword($user);
                return $this->redirectTo('security/login', 'Na adres użytkownika
                    <strong>została wysłana wiadomość</strong> z instrukcją dot. zmiany hasła.
                    Jeżeli e-mail nie dotrze w ciągu 10 minut, <a href="mailto:support@rebel.pl">skontaktuj się z nami</a>.', View::FLASH_SUCCESS);

            }
            else {

                $form->addError('Nie znaleziono takiego użytkownika.', 'login');

            }
        }

        return $form;
    }

    /**
     * @param  User $user
     * @return $this
     */
    private function sendForgotPassword(User $user)
    {
        $token = User\Token::create([
            'user' => $user,
            'type' => User\Token::RESET_PASSWORD,
            'expires_at' => (new \DateTime())->modify('+7 day'),
        ]);

        $template = new Email\Security\ForgotPassword([
            'user' => $user,
            'url' => $this->urlTo('security/reset/' . $user->id() . '?token=' .  $token, true),
        ]);

        $template->send();
        return $this;
    }

    /**
     * @param  User $user
     * @param  string $type
     * @return $this
     */
    private function verifyToken($user, $type)
    {
        $value = $this->getRequest()->getQuery('token');
        if (empty($value)) {
            return $this->redirectTo('/', 'Nieprawidłowy token użytkownika.', View::FLASH_ERROR);
        }

        $token = User\Token::findOneByUserTypeAndValue($user->id(), $type, $value);
        if (null === $token) {
            return $this->redirectTo('/', 'Nieprawidłowy token użytkownika.', View::FLASH_ERROR);
        }

        return $this;
    }
}