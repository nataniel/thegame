<?php
namespace Main\Form\Security;

use E4u\Form;

class Login extends Form\Base
{
    public function init()
    {
        $this->addFields([

            new Form\Element\EmailAddress('email', [
                'label' => 'Twój adres e-mail',
                'required' => 'Podaj adres e-mail.',
            ]),

            new Form\Element\Password('password', [
                'label' => 'Hasło',
                'required' => 'Podaj hasło dostępowe.',
            ]),

            new Form\Element\CheckBox('remember', [
                'label' => 'zapamiętaj hasło',
                'default' => true,
            ]),

            new Form\Element\Submit('submit', 'Zaloguj się'),

        ]);
    }
}