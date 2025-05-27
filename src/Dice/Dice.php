<?php

namespace App\Dice;

class Dice
{
    protected int $value;

    /**
     * Where we make a dice.
     */
    public function __construct()
    {
        $this->value = random_int(1, 6);
    }

    /**
     * @return int return the dice value.
     */
    public function roll(): int
    {
        $this->value = random_int(1, 6);
        return $this->value;
    }

    /**
     * Get the String of a dice.
     */
    public function getAsString(): string
    {
        return "[{$this->value}]";
    }
}
