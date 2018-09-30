<?php
namespace Main\Controller;

use Main\Model\Game;

class IndexController extends AbstractController
{
    public function indexAction()
    {
        $server = $this->getGameServer();
        $player = $server->getPlayer();

        return [
            'player' => $player,
        ];
    }

    /**
     * @return Game\Server
     */
    private function getGameServer()
    {
        $user = $this->getCurrentUser();
        return new Game\Server($user);
    }
}