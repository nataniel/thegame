<?php
namespace Main\Email\Security;

use E4u\Mailer\Template;
use Main\Model\User;

class UserActivation extends Template
{
    public function init()
    {
        $this
            ->setFrom('sklep@rebel.pl', 'REBEL.pl')
            ->setTo($this->getUser())
            ->addToHeaders('X-UserID', $this->getUser())
            ->setSubject('Potwierdzenie rejestracji konta w REBEL.pl')
            ->setContent('
Witaj [[user.wolacz]]

Poniżej znajduje się link, dzięki któremu możesz
potwierdzić rejestrację konta w REBEL.pl:
[[url]]

Pozdrawiam serdecznie

-- 
Tomasz Kiczorowski
Dział Obsługi Klienta

REBEL.pl http://www.rebel.pl/
Największy polski sklep z grami
ul. Budowlanych 64c, 80-298 Gdańsk
tel. 58 728 49 31');

        return $this;
    }

    /**
     * @return User
     */
    private function getUser()
    {
        return $this->vars['user'];
    }
}