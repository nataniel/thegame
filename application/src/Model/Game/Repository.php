<?php
namespace Main\Model\Game;

use E4u\Model\Repository as E4uRepository;
use Main\Model\Game;
use Main\Model\User;

class Repository extends E4uRepository
{
    /**
     * @param  User $user
     * @return Game[]
     */
    public function findActiveByUser(User $user)
    {
        $dql = "SELECT g
                FROM Main\\Model\\Game g
                JOIN g.players p
                WHERE p.user = :user
                  AND g.current_status < :current_status
                ORDER BY g.current_status DESC";
        return $this->_em
            ->createQuery($dql)
            ->setParameter('user', $user)
            ->setParameter('current_status', Game::STATUS_FINISHED)
            ->getResult();
    }

    /**
     * @param  User $user
     * @return Game[]
     */
    public function findFinishedByUser(User $user)
    {
        $dql = "SELECT g
                FROM Main\\Model\\Game g
                JOIN g.players p
                WHERE p.user = :user
                  AND g.current_status = :current_status";
        return $this->_em
            ->createQuery($dql)
            ->setParameter('user', $user)
            ->setParameter('current_status', Game::STATUS_FINISHED)
            ->getResult();
    }

    /**
     * @return Game[]
     */
    public function findAllStarted()
    {
        return $this->findBy(
            [ 'current_status' => Game::STATUS_STARTED ],
            [ 'id' => 'ASC', ]);
    }

    /**
     * @return Game[]
     */
    public function findAllOpen()
    {
        $dql = "SELECT g
                FROM Main\\Model\\Game g
                LEFT JOIN g.players p
                WHERE g.current_status = :current_status
                GROUP BY g
                HAVING COUNT(p) < g.max_players";
        return $this->_em
            ->createQuery($dql)
            ->setParameter('current_status', Game::STATUS_WAITING)
            ->getResult();
    }
}