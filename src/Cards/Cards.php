<?php

namespace App\Cards;

class Cards
{
    /** @var string */
    protected $value;

    /** @var string */
    protected $suit;

    public function __construct(string $value, string $suit)
    {
        $this->value = $value;
        $this->suit = $suit;
    }

    public function getSuit(): string
    {
        return $this->suit;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getAsString(): string
    {
        return "[{$this->value}, {$this->suit}]";
    }
}
