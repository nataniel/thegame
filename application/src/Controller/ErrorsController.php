<?php
namespace Main\Controller;

use E4u\Application\Controller\Errors as E4uErrors;

class ErrorsController extends AbstractController implements E4uErrors
{
    protected $defaultLayout = 'layout/security';

    public function notFoundAction()
    {
    }

    public function invalidAction()
    {
    }
}