<?php
namespace Main\Form\Security;

use E4u\Form;
use Main\Model\User;

class Register extends Form\Base
{
    public function init()
    {
        $this->addFields([

            new Form\Element\TextField('name', [
                'label' => 'Twoje imię i nazwisko',
                'required' => 'Podaj imię i nazwisko.',
            ]),

            new Form\Element\EmailAddress('email', [
                'label' => 'Twój adres e-mail',
                'required' => 'Podaj adres e-mail.',
                'placeholder' => 'np. kasia123@jakasdomena.pl',
            ]),

            new Form\Element\Password('password', [
                'label' => 'Hasło',
                'required' => 'Wybierz hasło dostępowe.',
            ]),

            new Form\Element\Password('password_confirmation', [
                'label' => 'Powtórz hasło',
                'required' => 'Wpisz hasło dostępowe powtórnie.',
            ]),

            new Form\Element\Submit('submit', 'Zarejestruj się'),

        ]);

        return $this;
    }

    public function validate()
    {
        parent::validate();
        $values = $this->getValues();

        if (!empty($values['password'])) {
            if ($values['password'] != $values['password_confirmation']) {
                $this->addError('Hasła muszą być takie same.', 'password_confirmation');
            }
        }

        if (!empty($values['login'])) {
            if (User::loginExists($values['login'])) {
                $this->addError('Ta nazwa użytkownika jest już zajęta.', 'login');
            }
        }


        return $this;
    }
}