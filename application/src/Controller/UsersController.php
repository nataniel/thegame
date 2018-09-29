<?php
namespace Main\Controller;

use Main\Model\Game;
use Main\Model\User;

class UsersController extends AbstractController
{
    public function showAction()
    {
        $user = $this->getUserFromParam();
        $activeGames = Game::getRepository()->findActiveByUser($user);
        $finishedGames = Game::getRepository()->findFinishedByUser($user);

        return [
            'title' => $user->getName(),
            'activeGames' => $activeGames,
            'finishedGames' => $finishedGames,
            'user' => $user,
        ];
    }

    /**
     * @return User
     */
    private function getUserFromParam()
    {
        $id = (int)$this->getParam('id');
        if (empty($id)) {
            return $this->redirectTo('/',
                'Brak ID użytkownika.',
                \E4u\Application\View::FLASH_ERROR);
        }

        $user = User::find($id);
        if (empty($user)) {
            return $this->redirectTo('/',
                'Nieprawidłowy ID użytkownika.',
                \E4u\Application\View::FLASH_ERROR);
        }

        return $user;
    }
}