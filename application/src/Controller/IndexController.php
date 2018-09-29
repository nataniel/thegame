<?php
namespace Main\Controller;

use Main\Model\Game;

class IndexController extends AbstractController
{
    public function indexAction()
    {
        $userGames = ($user = $this->getCurrentUser())
            ? Game::getRepository()->findActiveByUser($user)
            : [];

        $openGames = Game::getRepository()->findAllOpen();

        return [
            'userGames' => $userGames,
            'openGames' => $openGames,
        ];
    }
}