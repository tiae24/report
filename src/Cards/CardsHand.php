<?php

namespace App\Cards;

use App\Cards\Cards;
use App\Cards\CardsGraphic;
use App\Cards\DeckOfCards;

class CardHand
{
    private $hand = [];

    public function add(Cards $die): void
    {
        $this->hand[] = $die;
    }

    public function drawCards(): void
    {
        $removedDeck = new DeckOfCards();
    }

    public function getNumberDices(): int
    {
        return count($this->hand);
    }

    public function getValues(): array
    {
        $values = [];
        foreach ($this->hand as $die) {
            $values[] = $die->getValue();
        }
        return $values;
    }

    public function getString(): array
    {
        $values = [];
        foreach ($this->hand as $die) {
            $values[] = $die->getAsString();
        }
        return $values;
    }
}
