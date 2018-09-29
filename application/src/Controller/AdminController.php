<?php
namespace Main\Controller;

use E4u\Application\View;
use Main\Model\User;

class AdminController extends AbstractController
{
    protected $requiredPrivileges = [ User\Privilege::ADMIN ];

    public function loginAction()
    {
        $id = (int)$this->getParam('id');
        if (empty($id)) {
            return $this->redirectTo('/');
        }

        $user = User::find($id);
        if (null === $user) {
            return $this->redirectTo('/');
        }

        $this->getAuthentication()->loginAs($user);
        $message = sprintf(
            'Zalogowano jako <strong>%s</strong> (%s).',
            $user->getName(), $user->getLogin());
        return $this->redirectBackOrTo('/', $message, View::FLASH_SUCCESS);
    }

    public function resetAction()
    {
        $cacheDriver = \E4u\Loader::getDoctrine()->getConfiguration()->getMetadataCacheImpl();
        $cacheDriver->deleteAll();
        return $this->redirectBackOrTo('/', 'Dane w pamięci podręcznej (cache) zostały usunięte.');
    }
}