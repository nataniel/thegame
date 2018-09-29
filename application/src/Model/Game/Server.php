<?php
namespace Main\Model\Game;

use E4u\Tools\Console;
use Main\Model\Game;

class Server extends Console\Base
{
    const HELP = 'Starts';
    private $stopSignal = false;

    public function execute()
    {
        while (!$this->stopSignal) {
            $games = Game::getRepository()->findAllStarted();

            $cnt = count($games);
            foreach ($games as $game) {
                if ($game->tryNextTurn()) {
                    # echo sprintf("\n\nNEXT TURN (%d) STARTED: %s\n\n", $game->getCurrentTurn(), $game->showEntity());
                    $game->save();
                }

                echo sprintf("\r%s - %d active games, ", date('d.m.Y H:i:s'), $cnt);
                echo sprintf('memory usage: %.2f', memory_get_usage(true) / 1048576) . " MB    ";
            }

            \E4u\Loader::getDoctrine()->clear();
            sleep(1);
        }

    }
}