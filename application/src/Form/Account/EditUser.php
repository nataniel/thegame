<?php
namespace Main\Form\Account;

use E4u\Form;

class EditUser extends Form\Base
{
    public function init()
    {
        $this->addFields([

            new Form\Element\TextField('name', [
                'label' => 'Imię i nazwisko',
                'required' => 'Podaj imię i nazwisko.',
                'model' => $this->getModel('user'),
            ]),

            new Form\Element\EmailAddress('email', [
                'label' => 'Adres e-mail',
                'required' => 'Podaj adres e-mail.',
                'model' => $this->getModel('user'),
                'readonly' => true,
            ]),

            new Form\Element\TextField('avatar', [
                'label' => 'Adres URL avatara',
                'model' => $this->getModel('user'),
            ]),

            new Form\Element\Submit('submit', 'Zapisz zmiany'),

        ]);

        return $this;
    }
}