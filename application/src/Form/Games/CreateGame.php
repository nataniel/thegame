<?php
namespace Main\Form\Games;

use E4u\Form;

class CreateGame extends Form\Base
{
    public function init()
    {
        $this->addFields([

            new Form\Element\TextField('name', [
                'label' => 'Nazwa rozgrywki',
                'required' => 'Podaj nazwę rozgrywki.',
                'model' => $this->getModel('game'),
            ]),

            new Form\Element\Select('max_players', [
                'label' => 'Max graczy',
                'required' => 'Podaj max. liczbę graczy.',
                'options' => [
                    1 => 1,
                    2 => 2,
                    3 => 3,
                    4 => 4,
                ],
                'model' => $this->getModel('game'),
            ]),

            new Form\Element\Password('password', [
                'label' => 'Hasło (opcjonalnie)',
            ]),

            new Form\Element\Submit('submit', 'Utwórz grę'),

        ]);
    }
}