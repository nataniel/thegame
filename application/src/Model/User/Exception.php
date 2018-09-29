<?php
namespace Main\Model\User;

class Exception extends \E4u\Model\Exception
{
    const USER_ALREADY_REGISTERED = 1;
    const EMAIL_ALREADY_REGISTERED = 2;
    const EMAIL_IS_REQUIRED = 3;
    const INVALID_TOKEN = 4;
}