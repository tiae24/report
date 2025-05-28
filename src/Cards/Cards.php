<?php

namespace App\Cards;

/**
 * Class Cards.
 *
 * Here we make our playing cards.
 */
class Cards
{
    /** @var string */
    protected $value;

    /** @var string */
    protected $suit;

    /**
     * method Construct
     *
     * Here we make our card, we give it a value and a suit.
     */
    public function __construct(string $value, string $suit)
    {
        $this->value = $value;
        $this->suit = $suit;
    }

    /**
     * method getSuit
     *
     * Here we return the suit of our card.
     *
     * @return string return card suit.
     */
    public function getSuit(): string
    {
        return $this->suit;
    }

    /**
     * method getvalue
     *
     * Here we return the value of our card.
     *
     * @return string return card value.
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * method getAsString
     *
     * Return both The Value and Suit of the card.
     */
    public function getAsString(): string
    {
        return "[{$this->value}, {$this->suit}]";
    }
}
