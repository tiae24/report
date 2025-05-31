<?php

namespace App\Cards;

use App\Cards\Cards;

/**
 * Class CardGraphic.
 *
 * Here we give our cards their "faces", we basically style them for our site.
 */
class CardGraphic extends Cards
{
    /**
     * This is where we will get a card "image" based on the suit and value.
     * We have 4 suits and then cards from Ace to King.
     * @var array<string, array<int|string, string>>
     */
    private array $representation = [
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


    /**
     * Constructor
     */
    public function __construct(string $values, string $suits)
    {
        parent::__construct($values, $suits);
    }

    /**
     * Here we get the card "image" based on the suit and value.
     */

    public function getAsString(): string
    {
        return $this->representation[$this->suit][$this->value];
    }


}
