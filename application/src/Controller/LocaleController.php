<?php
namespace Main\Controller;

class LocaleController extends AbstractController
{
    public function plAction()
    {
        $_SESSION['locale'] = 'pl';
        return $this->redirectBackOrTo('/');
    }

    public function enAction()
    {
        $_SESSION['locale'] = 'en';
        return $this->redirectBackOrTo('/');
    }
}