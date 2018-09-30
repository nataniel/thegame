<?php
namespace Main\Controller;

use Main\Form\Account\EditUser;
use Main\Model\User;

class AccountController extends AbstractController
{
    public function indexAction()
    {
        $editForm = new EditUser($this->getRequest(), [ 'user' => $this->getCurrentUser(), ], 'edit');
        if ($editForm->isValid()) {
            $this->getCurrentUser()->save();
            $this->redirectBackOrTo('/', 'Zmiany zostały zapisane.');
        }

        return [
            'title' => $this->getCurrentUser()->getName(),
            'editForm' => $editForm,
        ];
    }

    public function profileAction()
    {
        $profile = $this->getProfileFromParam();
        if ($profile->getUser()->id() != $this->getCurrentUser()->id()) {

            return $this->redirectTo('/account',
                sprintf("Ten profil %s nie jest połączony z Twoim kontem.", $profile->getTypeName()),
                \E4u\Application\View::FLASH_ERROR);

        }

        $profile->destroy();
        return $this->redirectTo('/account',
            sprintf("Profil %s został usunięty z Twojego konta.", $profile->getTypeName()),
            \E4u\Application\View::FLASH_MESSAGE);
    }

    /**
     * @return User\Profile
     */
    private function getProfileFromParam()
    {
        $id = (int)$this->getParam('id');
        if (empty($id)) {
            return $this->redirectTo('/account');
        }

        $profile = User\Profile::find($id);
        if (null === $profile) {
            return $this->redirectTo('/account');
        }

        return $profile;
    }
}