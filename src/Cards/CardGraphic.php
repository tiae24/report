<?php

namespace App\Cards;

use App\Cards\Cards;

class CardGraphic extends Cards
{
    private $representation = [
        'spades' => [
            'A' => '🂡', '2' => '🂢', '3' => '🂣', '4' => '🂤', '5' => '🂥',
            '6' => '🂦', '7' => '🂧', '8' => '🂨', '9' => '🂩', '10' => '🂪',
            'J' => '🂫', 'Q' => '🂭', 'K' => '🂮',
        ],
        'hearts' => [
            'A' => '🂱', '2' => '🂲', '3' => '🂳', '4' => '🂴', '5' => '🂵',
            '6' => '🂶', '7' => '🂷', '8' => '🂸', '9' => '🂹', '10' => '🂺',
            'J' => '🂻', 'Q' => '🂽', 'K' => '🂾',
        ],
        'diamonds' => [
            'A' => '🃁', '2' => '🃂', '3' => '🃃', '4' => '🃄', '5' => '🃅',
            '6' => '🃆', '7' => '🃇', '8' => '🃈', '9' => '🃉', '10' => '🃊',
            'J' => '🃋', 'Q' => '🃍', 'K' => '🃎',
        ],
        'clubs' => [
            'A' => '🃑', '2' => '🃒', '3' => '🃓', '4' => '🃔', '5' => '🃕',
            '6' => '🃖', '7' => '🃗', '8' => '🃘', '9' => '🃙', '10' => '🃚',
            'J' => '🃛', 'Q' => '🃝', 'K' => '🃞',
        ]
    ];

    public function __construct(string $values, string $suits)
    {
        parent::__construct($values, $suits);
    }

    public function getAsString(): string
    {
        return $this->representation[$this->suit][$this->value];
    }

    /**
     * @return string
     */
    public function getSuit(): string
    {
        return $this->value[$this->$suit];
    }

}
