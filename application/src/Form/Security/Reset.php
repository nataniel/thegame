<?php
namespace Main\Form\Security;

use E4u\Form;

class Reset extends Form\Base
{
    public function init()
    {
        $this->addFields([

            new Form\Element\TextField('login', [
                'label' => 'Login',
                'readonly' => true,
            ]),

            new Form\Element\Password('password', [
                'label' => 'Nowe hasło',
                'required' => 'Wpisz hasło dostępowe.',
            ]),

            new Form\Element\Password('password_confirmation', [
                'label' => 'Powtórz hasło',
                'required' => 'Wpisz hasło dostępowe powtórnie.',
            ]),

            new Form\Element\Submit('submit', 'Zapisz zmiany'),

        ]);

        return $this;
    }

    public function validate()
    {
        parent::validate();
        if (!empty($this->getValue('password'))) {
            $values = $this->getValues();
            if ($values['password'] != $values['password_confirmation']) {
                $this->addError('Hasła muszą być takie same.', 'password_confirmation');
            }
        }

        return $this;
    }
}