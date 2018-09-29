<?php
return [
    'game.status' => [
        \Main\Model\Game::STATUS_WAITING => 'waiting for players',
        \Main\Model\Game::STATUS_STARTED => 'currently playing (turn&nbsp;%d)',
        \Main\Model\Game::STATUS_FINISHED => 'finished',
    ],

    'player' => [

        'building' => [
            'barracks' => [
                'name' => 'Barracks',
                'description' => '',
            ],
            'farm' => [
                'name' => 'Farm',
                'description' => '',
            ],
            'forester' => [
                'name' => 'Forester\'s Lodge',
                'description' => '',
            ],
            'library' => [
                'name' => 'Library',
                'description' => '',
            ],
            'mine' => [
                'name' => 'Mine',
                'description' => '',
            ],
        ],

        'unit' => [
            'archer' => [
                'name' => 'Archers',
                'description' => '',
            ],
            'cleric' => [
                'name' => 'Clerics',
                'description' => '',
            ],
            'knight' => [
                'name' => 'Knights',
                'description' => '',
            ],
            'warrior' => [
                'name' => 'Warriors',
                'description' => '',
            ],
        ],

        'supply' => [
            'food' => [
                'name' => 'Food',
                'description' => '',
            ],
            'gold' => [
                'name' => 'Gold',
                'description' => '',
            ],
            'science' => [
                'name' => 'Science',
                'description' => '',
            ],
            'stone' => [
                'name' => 'Stone',
                'description' => '',
            ],
            'wood' => [
                'name' => 'Wood',
                'description' => '',
            ],
        ],

        'technology' => [
            'animalbreeding' => 'Animal breeding',
            'architecture' => 'Architektura',
            'farming' => 'Farming',
            'gathering' => 'Gathering',
            'irrigation' => 'Irrigation',
            'literature' => 'Literature',
            'masonry' => 'Masonry',
            'mining' => 'Mining',
            'stoneworks' => 'Kamieniarstwo',
            'warfare' => 'Warfare',
            'writing' => 'Writing',
        ],

        'event' => [
            'battle' => [
                'name' => 'Attack of barbarians',
                'description' => 'Twój gród został zaatakowany przez dzikie hordy barbarzyńców! Przygotuj się do obrony!',
            ],
            'drought' => [
                'name' => 'Drought',
                'description' => 'Wyjątkowo zła pogoda spowodowała słabe zbiory w tym roku.',
            ],
        ],

        'phase' => [
            \Main\Model\Player::PHASE_BEGINTURN => 'beginning of turn',
            \Main\Model\Player::PHASE_PRODUCTION => 'production phase',
            \Main\Model\Player::PHASE_EVENTRESOLUTION => 'event resolution',
            \Main\Model\Player::PHASE_DEVELOPMENT => 'technology development',
            \Main\Model\Player::PHASE_ACTION => 'action phase',
            \Main\Model\Player::PHASE_ENDTURN => 'waiting for end turn',
        ],
    ],

    // games/play/_supplies
    'Zasoby <small>(produkcja)</small>' => 'Resources <small>(production)</small>',

    // games/play/_units
    'Jednostki wojskowe <small>/ max</small>' => 'Military units <small>/ max</small>',

    // games/play/_buildings
    'Budynki <small>(max. %d)</small>' => 'Buildings <small>(max. %d)</small>',

    // games/play/_technologies
    'Dostępne technologie' => 'Available technologies',
    'zobacz wynalezione technologie' => 'view developed technologies',

    // games/setup
    'Rozpocznij rozgrywkę' => 'Start game',
    'Dołącz do rozgrywki' => 'Join game',

    // games/_players
    'Lista graczy (%d / %d)' => 'List of players (%d / %d)',
    'Opuść rozgrywkę' => 'Leave game',

    // layout/_sidebar
    'Ustawienia' => 'Settings',
    'Wyloguj się' => 'Log out',
    'Zaloguj się' => 'Log in',

    // index/index
    'Twoje aktywne gry' => 'Your games',
    'Gry oczekujące na graczy' => 'Games waiting for players',
    'Utwórz nową rozgrywkę' => 'Create new game',

    // users/show
    'Aktywne rozgrywki' => 'Current games',
    'Zakończone rozgrywki' => 'Finished games',

    // games/play/_actions
    'Zakończ aktualną turę' => 'Finish current turn',
    'Czy na pewno zakończyć aktualną turę?' => 'Are you sure you want to finish current turn?',
    '<strong>Twoje królestwo nie jest bronione!</strong> W przypadku ataku nastąpi koniec gry.' => '<strong>Your kingdom is not protected!</strong> If you are attacked, the game will end.',
];