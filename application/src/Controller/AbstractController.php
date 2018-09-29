<?php
namespace Main\Controller;

use E4u\Application\Controller as E4uController;
use Main\Configuration;
use Main\Model\User;

abstract class AbstractController extends E4uController
{
    protected $defaultLayout = 'layout/default';
    protected $viewClass = \Main\View\Base::class;

    public function init($action)
    {
        if (Configuration::isSSLRequired() && !$this->getRequest()->isSSL()) {
            return $this->redirectTo('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        }
    }

    /**
     * @return User
     */
    public function getCurrentUser()
    {
        return parent::getCurrentUser();
    }
}