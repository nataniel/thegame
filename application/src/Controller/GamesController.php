<?php
namespace Main\Controller;

use E4u\Application\View;
use Main\Model\Game;

class GamesController extends AbstractController
{
    protected $requiredPrivileges = true;

    public function startAction()
    {
        $server = $this->getGameServer();
        $server->createPlayer()->save();

        return $this->redirectTo('/play',
            'Nowa gra została utworzona.',
            View::FLASH_SUCCESS);
    }

    public function resetAction()
    {
        $server = $this->getGameServer();
        $server->resetGame()->save();

        return $this->redirectTo('/play',
            'Gra została zresetowana.',
            View::FLASH_SUCCESS);
    }

    public function removeAction()
    {
        $server = $this->getGameServer();
        $server->destroyPlayer()->save();

        return $this->redirectTo('/',
            'Gra została zakończona.',
            View::FLASH_SUCCESS);
    }

    /**
     * @return Game\Server
     */
    private function getGameServer()
    {
        $user = $this->getCurrentUser();
        return new Game\Server($user);
    }


//    public function indexAction()
//    {
//        $game = $this->getGameFromParam();
//        $player = $this->getCurrentPlayer($game);
//
//        switch ($game->getCurrentStatus()) {
//            case Game::STATUS_WAITING:
//                return $this->renderView('setup', $this->setupGame($game));
//
//            case Game::STATUS_STARTED:
//                return !empty($player)
//                    ? $this->renderView('play', $this->playGame($game, $player))
//                    : $this->renderView('spectate', $this->spectateGame($game));
//
//            case Game::STATUS_FINISHED:
//                return $this->renderView('finished', $this->finishedGame($game));
//
//            default:
//                return $this->redirectTo('/', 'Nieprawidłowy status gry?');
//        }
//    }
//
//    public function technologiesAction()
//    {
//        $game = $this->getGameFromParam();
//        $player = $this->getCurrentPlayer($game);
//
//        $technologies = $player->getDevelopedTechnologies();
//        return [
//            'game' => $game,
//            'player' => $player,
//            'technologies' => $technologies,
//        ];
//    }
//
//    /**
//     * @param  Game $game
//     * @param  Player $player
//     * @return mixed[]
//     */
//    protected function playGame(Game $game, Player $player)
//    {
//        switch ($player->getCurrentPhase()) {
//
//            case Player::PHASE_BEGINTURN:
//                $result = $this->getBeginTurnPhaseResult($game, $player);
//                break;
//
//            case Player::PHASE_PRODUCTION:
//                $result = $this->getProductionPhaseResult($game, $player);
//                break;
//
//            case Player::PHASE_EVENTRESOLUTION:
//                $result = $this->getEventResolutionPhaseResult($game, $player);
//                break;
//
//            case Player::PHASE_DEVELOPMENT:
//                $result = $this->getDevelopmentPhaseResult($game, $player);
//                break;
//
//            default:
//                $result = [];
//        }
//
//        return array_merge([
//            'title' => $game->getName(),
//            'game' => $game,
//            'player' => $player,
//        ], $result);
//    }
//
//    protected function getBeginTurnPhaseResult(Game $game, Player $player)
//    {
//        $this->getView()->addFlash(sprintf(
//            'Rozpoczęła się: <strong>Tura %d</strong>.', $game->getCurrentTurn()),
//            View::FLASH_MESSAGE);
//
//        return $this->getProductionPhaseResult($game, $player);
//    }
//
//    protected function getProductionPhaseResult(Game $game, Player $player)
//    {
//        $player->productionPhase()->save();
//        return $this->getEventResolutionPhaseResult($game, $player);
//    }
//
//    protected function getEventResolutionPhaseResult(Game $game, Player $player)
//    {
//        $player->eventResolutionPhase()->save();
//        $event = $player->getCurrentEvent();
//        if (!empty($event)) {
//            $event->save();
//        }
//
//        if (is_null($event) || $this->getRequest()->getQuery('continue')) {
//            return $this->getDevelopmentPhaseResult($game, $player);
//        }
//
//        return [ 'event' => $event ];
//    }
//
//    protected function getDevelopmentPhaseResult(Game $game, Player $player)
//    {
//        $player->developmentPhase()->save();
//        $technology = $player->getActiveTechnology();
//        if (!empty($technology) && $technology->isDeveloped()) {
//
//            $technology->setActive(null);
//            $this->getView()->addFlash(sprintf(
//                'Wynaleziono technologię: <strong>%s</strong>: %s',
//                $this->t($technology->getName()),
//                $this->t($technology->getDescription())),
//                View::FLASH_MESSAGE);
//
//        }
//
//        $player->actionPhase()->save();
//        return $this->redirectTo($game);
//    }
//
//    /**
//     * @param  Game $game
//     * @return mixed[]
//     */
//    protected function spectateGame($game)
//    {
//        return [
//            'title' => $game->getName(),
//            'game' => $game,
//        ];
//    }
//
//    /**
//     * @param  Game $game
//     * @return mixed[]
//     */
//    protected function finishedGame($game)
//    {
//        return [
//            'title' => $game->getName(),
//            'game' => $game,
//        ];
//    }
//
//    /**
//     * @param  Game $game
//     * @return mixed[]
//     */
//    protected function setupGame($game)
//    {
//        return [
//            'title' => $game->getName(),
//            'game' => $game,
//        ];
//    }
//
//    public function createAction()
//    {
//        $game = new Game();
//        $createForm = new CreateGame($this->getRequest(), [ 'game' => $game ], 'create');
//        if ($createForm->isValid()) {
//
//            $game->joinUser($this->getCurrentUser());
//            $game->save();
//
//            return $this->redirectTo($game, sprintf(
//                'Gra <strong>#%d: %s</strong> została utworzona.', $game->id(), $game->getName()),
//                View::FLASH_SUCCESS);
//
//        }
//
//        return [
//            'title' => 'Utwórz nową grę',
//            'createForm' => $createForm,
//        ];
//    }
//
//    public function startAction()
//    {
//        $game = $this->getGameFromParam();
//        $game->start()->save();
//        $this->redirectTo($game, sprintf(
//            'Gra <strong>#%d: %s</strong> została uruchomiona.', $game->id(), $game->getName()),
//            View::FLASH_SUCCESS);
//    }
//
//    public function developAction()
//    {
//        $game = $this->getGameFromParam();
//        $type = $this->getRequest()->getQuery('type');
//
//        $player = $this->getCurrentPlayer($game);
//        $technology = $player->getTechnologyByType($type);
//        $technology->setActive()->save();
//
//        if ($technology->getProgress() > 0) {
//            $message = 'Kontynuacja prac nad technologią: <strong>%s</strong>: %s';
//        }
//        else {
//            $message = 'Rozpoczęto prace nad technologią <strong>%s</strong>: %s';
//        }
//
//        $this->redirectTo($game, sprintf($message,
//            $this->t($technology->getName()),
//            $this->t($technology->getDescription())),
//            View::FLASH_MESSAGE);
//    }
//
//    public function buildAction()
//    {
//        $game = $this->getGameFromParam();
//        $type = $this->getRequest()->getQuery('type');
//
//        $player = $this->getCurrentPlayer($game);
//        $building = $player->getBuildingByType($type);
//        $building->build()->save();
//
//        $this->redirectTo($game, sprintf(
//            'Wybudowano: <strong>%s</strong>: %s',
//            $this->t($building->getName()),
//            $this->t($building->getDescription())),
//            View::FLASH_SUCCESS);
//    }
//
//    public function recruitAction()
//    {
//        $game = $this->getGameFromParam();
//        $type = $this->getRequest()->getQuery('type');
//
//        $player = $this->getCurrentPlayer($game);
//        $unit = $player->getUnitByType($type);
//        $unit->recruit()->save();
//
//        $this->redirectTo($game, sprintf(
//            'Zatrudniono: <strong>%s</strong>: %s',
//            $this->t($unit->getName()),
//            $this->t($unit->getDescription())),
//            View::FLASH_SUCCESS);
//    }
//
//    public function endturnAction()
//    {
//        $game = $this->getGameFromParam();
//        $player = $this->getCurrentPlayer($game);
//
//        $turn = $game->getCurrentTurn();
//        $player->endTurnPhase()->save();
//
//        if ($game->tryNextTurn()) {
//            $game->save();
//            $this->redirectTo($game);
//        }
//
//        if ($game->isEndTurnReady()) {
//
//            sleep(2);
//            $game->refresh();
//            if ($game->getCurrentTurn() > $turn) {
//                $this->redirectTo($game);
//            }
//
//        }
//
//        $this->redirectTo($game, sprintf(
//            'Nadal możesz wykonywać akcje, jednak w momencie gdy ostatni
//             z pozostałych graczy zakończy turę, automatycznie rozpocznie
//             się nowa tura.', $game->id(), $game->getName()),
//            View::FLASH_MESSAGE);
//    }
//
//    public function restartAction()
//    {
//        $game = $this->getGameFromParam();
//        $game->restart()->save();
//        $this->redirectTo($game, sprintf(
//            'Gra <strong>#%d: %s</strong> została zresetowana.', $game->id(), $game->getName()),
//            View::FLASH_SUCCESS);
//    }
//
//    public function finishAction()
//    {
//        $game = $this->getGameFromParam();
//        $game->finish()->save();
//        $this->redirectTo($game, sprintf(
//            'Gra <strong>#%d: %s</strong> została zakończona.', $game->id(), $game->getName()),
//            View::FLASH_SUCCESS);
//    }
//
//    public function joinAction()
//    {
//        $game = $this->getGameFromParam();
//        $game->joinUser($this->getCurrentUser())->save();
//
//        return $this->redirectTo($game, sprintf(
//            'Dołączyłeś do rozgrywki <strong>#%d: %s</strong>.', $game->id(), $game->getName()),
//            View::FLASH_SUCCESS);
//    }
//
//    public function quitAction()
//    {
//        $game = $this->getGameFromParam();
//        $game->removeUser($this->getCurrentUser())->save();
//
//        return $this->redirectTo('/', sprintf(
//            'Opuściłeś rozgrywkę <strong>#%d: %s</strong>.', $game->id(), $game->getName()),
//            View::FLASH_MESSAGE);
//    }
//
//    /**
//     * @return Game|Response
//     */
//    private function getGameFromParam()
//    {
//        $id = (int)$this->getParam('id');
//        if (empty($id)) {
//            return $this->redirectTo('/',
//                'Brak ID rozgrywki.',
//                View::FLASH_ERROR);
//        }
//
//        $game = Game::find($id);
//        if (empty($game)) {
//            return $this->redirectTo('/',
//                'Nieprawidłowy ID rozgrywki.',
//                View::FLASH_ERROR);
//        }
//
//        return $game;
//    }
//
//    /**
//     * @param  Game $game
//     * @return Player
//     */
//    private function getCurrentPlayer(Game $game)
//    {
//        return $game->getPlayerByUser($this->getCurrentUser());
//    }
}