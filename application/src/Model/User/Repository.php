<?php
namespace Main\Model\User;

use E4u\Model\Repository as E4uRepository,
    E4u\Authentication\Identity\Repository as UserRepository;

class Repository extends E4uRepository implements UserRepository
{
    /**
     * @param  string $login
     * @return \Main\Model\User
     */
    public function findOneByLogin($login)
    {
        $dql = "SELECT u
                FROM Main\\Model\\User u
                WHERE u.login = :login";
        return $this->_em
            ->createQuery($dql)
            ->setParameter('login', $login)
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }
}