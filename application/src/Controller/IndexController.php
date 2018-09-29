<?php
namespace Main\Controller;

use Main\Model\Game;

class IndexController extends AbstractController
{
    public function indexAction()
    {
        if ($user = $this->getCurrentUser()) {
            $userGames = Game::getRepository()->findActiveByUser($user);
        }
        else {
            $userGames = [];
        }

        $openGames = Game::getRepository()->findAllOpen();

        return [
            'userGames' => $userGames,
            'openGames' => $openGames,
        ];
    }
}