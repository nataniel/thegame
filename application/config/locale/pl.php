<?php
return [
    'game.status' => [
//        \Main\Model\Game::STATUS_WAITING => 'oczekuje na graczy',
//        \Main\Model\Game::STATUS_STARTED => 'w trakcie rozgrywki (tura&nbsp;%d)',
//        \Main\Model\Game::STATUS_FINISHED => 'zakończona',
    ],

    'player' => [

        'building' => [
            'barracks' => [
                'name' => 'Koszary',
                'description' => 'Zapewnia miejsce dla 5 zbrojnych.',
            ],
            'farm' => [
                'name' => 'Farma',
                'description' => 'Produkuje 2 żywności.',
            ],
            'forester' => [
                'name' => 'Leśniczówka',
                'description' => 'Produkuje 1 drewna i 1 żywności.',
            ],
            'library' => [
                'name' => 'Biblioteka',
                'description' => 'Produkuje 5 nauki.',
            ],
            'mine' => [
                'name' => 'Kopalnia',
                'description' => 'Produkuje 2 kamienia i 1 złota.',
            ],
            'monastery' => [
                'name' => 'Klasztor',
                'description' => 'Zapewnia miejsce dla 5 kleryków.',
            ],
        ],

        'unit' => [
            'archer' => [
                'name' => 'Łucznicy',
                'description' => 'Jednostka walcząca na dystans, słaba w starciu bezpośrednim.',
            ],
            'cleric' => [
                'name' => 'Klerycy',
                'description' => 'Jednostka lecząca w armii.',
            ],
            'knight' => [
                'name' => 'Rycerze',
                'description' => 'Zaawansowana jednostka wojskowa.',
            ],
            'warrior' => [
                'name' => 'Zbrojni',
                'description' => 'Podstawowa jednostka wojskowa.',
            ],
        ],

        'supply' => [
            'food' => [
                'name' => 'Żywność',
                'description' => 'Podstawowy zasób do budowy jednostek wojskowych i niektórych budynków.',
            ],
            'gold' => [
                'name' => 'Złoto',
                'description' => 'Wymagane do budowy zaawansowanych jednostek wojskowych, jak rycerze i klerycy.',
            ],
            'science' => [
                'name' => 'Nauka',
                'description' => 'Suma zgromadzonej wiedzy.',
            ],
            'stone' => [
                'name' => 'Kamień',
                'description' => 'Wymagany do budowania zaawansowanych budynków.',
            ],
            'wood' => [
                'name' => 'Drewno',
                'description' => 'Podstawowy zasób do budowy budynków i niektórych jednostek.',
            ],
        ],

        'technology' => [
            'animalbreeding' => [
                'name' => 'Hodowla zwierząt',
                'description' => 'Obniża koszt jednostek o 1 żywności.',
            ],
            'archery' => [
                'name' => 'Łucznictwo',
                'description' => 'Pozwala budować łuczników.',
            ],
            'architecture' => [
                'name' => 'Architektura',
                'description' => 'Zwiększa limit budynków o 1. Pozwala budować kościoły, zwiększające limit kleryków.',
            ],
            'cavalry' => [
                'name' => 'Kawaleria',
                'description' => 'Pozwala rekrutować rycerzy.',
            ],
            'farming' => [
                'name' => 'Uprawa roli',
                'description' => 'Pozwala budować farmy, które wytwarzają żywność.',
            ],
            'gathering' => [
                'name' => 'Zbieractwo',
                'description' => 'Podstawowa technologia, dająca minimalną produkcję żywności, drewna i nauki.',
            ],
            'goldmining' => [
                'name' => 'Wydobycie złota',
                'description' => 'Każda kopalnia wydobywa dodatkowo 1 złota.',
            ],
            'irrigation' => [
                'name' => 'Irygacja',
                'description' => 'Zwiększa wydajność farm o 1.',
            ],
            'literature' => [
                'name' => 'Literatura',
                'description' => 'Pozwala budować biblioteki, które wytwarzają naukę.',
            ],
            'masonry' => [
                'name' => 'Murarstwo',
                'description' => 'Obniża koszt budynków o 1 kamień.',
            ],
            'mining' => [
                'name' => 'Górnictwo',
                'description' => 'Pozwala budować kopalnie, które wytwarzają kamień.',
            ],
            'religion' => [
                'name' => 'Religia',
                'description' => 'Pozwala zatrudniać kleryków, którzy leczą jednostki w walce i dają małą premię do nauki.',
            ],
            'stoneworks' => [
                'name' => 'Kamieniarstwo',
                'description' => 'Wydobycie kamienia + 1.',
            ],
            'warfare' => [
                'name' => 'Sztuka wojenna',
                'description' => 'Pozwala budować koszary, aby zatrudniać więcej zbrojnych.',
            ],
            'writing' => [
                'name' => 'Pismo',
                'description' => 'Zapewnia niewielką ilość nauki.',
            ],
        ],

        'event' => [
            'nothing' => [
                'name' => 'Nic się nie dzieje',
                'description' => 'Cisza i spokój.',
            ],
            'raiders' => [
                'name' => 'Grabieże',
                'description' => 'Twój gród został zaatakowany przez bandy grabieżców!',
            ],
            'barbarians' => [
                'name' => 'Barbarzyńcy',
                'description' => 'Twój gród został zaatakowany przez hordy barbarzyńców!',
            ],
            'drought' => [
                'name' => 'Susza',
                'description' => 'Wyjątkowo zła pogoda spowodowała słabe zbiory w tym roku.',
            ],
            'gameover' => [
                'name' => 'Game over',
                'description' => 'Niestety, przegrałeś rozgrywkę.',
            ],
        ],

        'phase' => [
//            \Main\Model\Player::PHASE_BEGINTURN => 'początek tury',
//            \Main\Model\Player::PHASE_PRODUCTION => 'faza produkcji',
//            \Main\Model\Player::PHASE_EVENTRESOLUTION => 'rozpatrywanie wydarzenia',
//            \Main\Model\Player::PHASE_DEVELOPMENT => 'wynajdowanie technologii',
//            \Main\Model\Player::PHASE_ACTION => 'faza akcji',
//            \Main\Model\Player::PHASE_ENDTURN => 'oczekuje na koniec tury',
        ],
    ],
];