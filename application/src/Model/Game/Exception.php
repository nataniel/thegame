<?php
namespace Main\Model\Game;
class Exception extends \E4u\Model\Exception
{
    const
        GAME_ALREADY_LAUNCHED = 1,
        MAX_PLAYERS_REACHED = 2,
        USER_ALREADY_JOINED = 3,
        USER_IS_NOT_PLAYER = 4,
        GAME_NOT_LAUNCHED = 5,
        UNRESOLVED_EVENT_EXISTS = 6,

        UKNOWN_EXCEPTION = 0;
}