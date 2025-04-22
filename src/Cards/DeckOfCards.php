<?php

namespace App\Cards;

use App\Cards\Cards;
use App\Cards\CardGraphic;

class DeckOfCards
{
    protected $cards = [];

    public function __construct()
    {
        $values = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
        $suits = ['hearts', 'diamonds', 'clubs', 'spades'];

        foreach ($suits as $suit) {
            foreach ($values as $value) {
                $card = new Cards($value, $suit);
                $graphicCard = new CardGraphic($value, $suit);
                $this->cards[] = [
                    'card' => $card,
                    'cardGraphic' => $graphicCard
                ];
            }
        }

    }

    public function getCards(): array
    {
        return $this->cards;
    }

    public function getString(): array
    {
        $values = [];
        foreach ($this->cards as $card) {
            $values[] = $card['card']->getAsString();
        }
        return $values;
    }

    public function getCard(): array
    {
        $values = [];
        foreach ($this->cards as $card) {
            $values[] = $card['cardGraphic']->getAsString();
        }
        return $values;
    }

    public function getSuit(): array
    {
        $values = [];
        foreach ($this->cards as $card) {
            $values[] = $card['card']->getSuit();
        }
        return $values;
    }

    public function totalCards(): int
    {
        return count($this->cards);
    }

    public function drawCard(int $amount): array
    {
        $max = $this->totalCards();

        $values = [];

        for ($i = 0; $i < $amount; $i++) {

            $number = random_int(0, $max - $i - 1);

            $values[] = [
                'suit' => $this->cards[$number]['card']->getSuit(),
                'card' => $this->cards[$number]['card']->getAsString(),
                'graphic' => $this->cards[$number]['cardGraphic']->getAsString()
            ];
            array_splice($this->cards, $number, 1);
        }

        return $values;
    }

    public function shuffle(): array
    {
        shuffle($this->cards);
        return $this->cards;
    }

    public function sort(): array
    {
        sort($this->cards);
        return $this->cards;
    }


}
