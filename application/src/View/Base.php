<?php
namespace Main\View;

use E4u\Application\View\Html as E4uView;
use E4u\Authentication\Identity;
use E4u\Form;
use Main\Model\User;
use Main\Helper;

class Base extends E4uView
{
    protected function registerHelpers()
    {
        $this->_helpers['avatar'] = Helper\UserAvatar::class;
        $this->_helpers['pln'] = Helper\NumberToPLN::class;
        $this->_helpers['price'] = Helper\ShowAssetPrice::class;
        parent::registerHelpers();
    }

    /**
     * @return User|Identity
     */
    public function getCurrentUser()
    {
        return parent::getCurrentUser();
    }

    /**
     * @param  Form\Base $form
     * @return Form\Builder\Bootstrap41
     */
    public function createBootstrapForm($form)
    {
        return new Form\Builder\Bootstrap41($form, $this);
    }
}