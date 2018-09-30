<?php
namespace Main\Controller;

use E4u\Application\View;
use Main\Model\Game;

class PlayController extends AbstractController
{
    protected $requiredPrivileges = true;

    public function indexAction()
    {
        $server = $this->getGameServer();
        $player = $server->getPlayer();

        return [
            'server' => $server,
            'title' => sprintf('Rozgrywka: %s (#%d) - tura %d', $player->getUser(), $player->id(), $player->getCurrentTurn()),
        ];
    }

    public function recruitAction()
    {
        $type = $this->getRequest()->getQuery('type');

        try {

            $server = $this->getGameServer();
            $unit = $server->recruit($type);
            $server->save();

            $this->getView()->addFlash(sprintf(
                'Zatrudniono: <strong>%s</strong>: %s',
                $this->t($unit->getName()),
                $this->t($unit->getDescription())), View::FLASH_SUCCESS);

        }
        catch (Game\Exception $ex) {
            $this->getView()->addFlash($ex->getMessage(), View::FLASH_ERROR);
        }

        return $this->redirectTo('/play');
    }

    public function buildAction()
    {
        $type = $this->getRequest()->getQuery('type');

        try {

            $server = $this->getGameServer();
            $building = $server->build($type);
            $server->save();

            $this->getView()->addFlash(sprintf(
                'Wybudowano: <strong>%s</strong>: %s',
                $this->t($building->getName()),
                $this->t($building->getDescription())), View::FLASH_SUCCESS);

        }
        catch (Game\Exception $ex) {
            $this->getView()->addFlash($ex->getMessage(), View::FLASH_ERROR);
        }

        return $this->redirectTo('/play');
    }

    public function developAction()
    {
        $type = $this->getRequest()->getQuery('type');

        try {

            $server = $this->getGameServer();
            $technology = $server->develop($type);
            $server->save();

            $message = $technology->getProgress() > 0
                ? 'Kontynuacja prac nad technologią: <strong>%s</strong>: %s'
                : 'Rozpoczęto prace nad technologią <strong>%s</strong>: %s';

            $this->getView()->addFlash(sprintf(
                $message,
                $this->t($technology->getName()),
                $this->t($technology->getDescription())), View::FLASH_SUCCESS);

        }
        catch (Game\Exception $ex) {
            $this->getView()->addFlash($ex->getMessage(), View::FLASH_ERROR);
        }

        return $this->redirectTo('/play');
    }

    public function endTurnAction()
    {
        try {

            $server = $this->getGameServer();
            $server->endTurn()->save();

        }
        catch (Game\Exception $ex) {
            $this->getView()->addFlash($ex->getMessage(), View::FLASH_ERROR);
        }

        return $this->redirectTo('/play');
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