<?php

namespace App\Cards;

use App\Cards\Cards;
use App\Cards\CardGraphic;

class DeckOfCards
{
    protected array $cards = [];

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

    /**
     * @return array<int, array{ card: string, graphic: string }>
     */
    public function getCards(): array
    {
        return $this->cards;
    }

    /**
     * @return array<int, string>
     */
    public function getString(): array
    {
        $values = [];
        foreach ($this->cards as $card) {
            $values[] = $card['card']->getAsString();
        }
        return $values;
    }

    /**
     * @return array<int, string>
     */
    public function getCard(): array
    {
        $values = [];
        foreach ($this->cards as $card) {
            $values[] = $card['cardGraphic']->getAsString();
        }
        return $values;
    }

    /**
     * @return array<int, string>
     */
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



    /**
     * @param int $amount
     * @return array<int, array{ suit: string, card: string, graphic: string }>
     */
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

    /**
     * @return array<int, array{ suit: string, card: string, graphic: string }>
     */
    public function shuffle(): array
    {
        shuffle($this->cards);
        return $this->cards;
    }

}
