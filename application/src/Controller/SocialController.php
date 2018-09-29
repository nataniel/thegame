<?php
namespace Main\Controller;

use E4u\Application\View;
use E4u\Authentication\Social;
use Main\Configuration;
use Main\Model\User;

class SocialController extends AbstractController
{
    public function googleAction()
    {
        $helper = new Social\Google(Configuration::googleConfig(), $this->getRequest());
        if ($helper->loginFromRedirect()) {

            $user = $this->getUserFromSocial($helper, User\Profile\Google::class);
            $this->setAvatarIfEmpty($user, $helper->getPicture());

            $user->save();
            return $this->loginAs($user);

        }

        $loginUrl = $helper->getLoginUrl();
        return $this->redirectTo($loginUrl);
    }

    public function facebookAction()
    {
        $helper = new Social\Facebook(Configuration::facebookConfig(), $this->getRequest());
        if ($helper->loginFromRedirect()) {

            $user = $this->getUserFromSocial($helper, User\Profile\Facebook::class);
            $this->setAvatarIfEmpty($user, $helper->getPicture());

            $user->save();
            return $this->loginAs($user);

        }

        $loginUrl = $helper->getLoginUrl();
        return $this->redirectTo($loginUrl);
    }

    public function twitterAction()
    {
        $helper = new Social\Twitter(Configuration::twitterConfig(), $this->getRequest());
        if ($helper->loginFromRedirect()) {

            $user = $this->getUserFromSocial($helper, User\Profile\Twitter::class);
            $this->setAvatarIfEmpty($user, $helper->getPicture());

            $user->save();
            return $this->loginAs($user);

        }

        $loginUrl = $helper->getLoginUrl();
        return $this->redirectTo($loginUrl);
    }

    public function steamAction()
    {
        $helper = new Social\Steam(Configuration::steamConfig(), $this->getRequest());
        if ($helper->loginFromRedirect()) {

            $user = $this->getUserFromSocial($helper, User\Profile\Steam::class);
            $this->setAvatarIfEmpty($user, $helper->getPicture());

            $user->save();
            return $this->loginAs($user);

        }

        $loginUrl = $helper->getLoginUrl();
        return $this->redirectTo($loginUrl);
    }

    private function loginAs(User $user)
    {
        $this->getAuthentication()->loginAs($user);
        $message = sprintf(
            'Zalogowano jako <strong>%s</strong> (%s).',
            $user->getName(), $user->getLogin());
        return $this->redirectBackOrTo('/', $message, View::FLASH_SUCCESS);
    }

    /**
     * @param User $user
     * @param string $picture
     */
    private function setAvatarIfEmpty(User $user, $picture)
    {
        if (empty($user->getAvatar()) && !empty($picture)) {
            $user->setAvatar($picture);
        }
    }

    /**
     * @param  Social\Helper $social
     * @param  string $profileClass
     * @return User
     */
    private function getUserFromSocial(Social\Helper $social, $profileClass)
    {
        // Profile already exists - login as connected user
        /** @var User\Profile $profile */
        $profile = $profileClass::findOneBy([ 'profile_id' => $social->getId() ]);
        if (!empty($profile)) {
            return $profile->getUser();
        }

        $profile = new $profileClass([
            'profile_id' => $social->getId(),
        ]);

        // Profile does not exists, but maybe user with primary email exists
        $user = User::getRepository()->findOneByLogin($social->getEmail());
        if (!empty($user)) {
            $user->addToProfiles($profile);
            return $user;
        }

        // ... or user is currently logged in
        if ($user = $this->getCurrentUser()) {
            $user->addToProfiles($profile);
            return $user;
        }

        // no profile, no user - create new user with no password
        return new User([
            'login' => $social->getEmail(),
            'first_name' => $social->getFirstName(),
            'last_name' => $social->getLastName(),
            'avatar' => $social->getPicture(),
            'locale' => $social->getLocale(),
            'profiles' => [ $profile ],
        ]);
    }
}