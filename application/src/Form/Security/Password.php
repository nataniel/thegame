<?php
namespace Main\Form\Security;

use E4u\Form;

class Password extends Form\Base
{
    public function init()
    {
        $this->addFields([

            new Form\Element\TextField('login', [
                'label' => 'Twój adres e-mail',
                'required' => 'Podaj adres e-mail.',
                'placeholder' => 'np. kasia123@jakasdomena.pl',
            ]),

            new Form\Element\Submit('submit', 'Wyślij'),

        ]);

        return $this;
    }
}