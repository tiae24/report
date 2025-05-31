<?php

namespace App\Project;

use App\Project\Cards;
use App\Project\CardGraphic;

/**
 * Class DeckOfCards.
 *
 * Here we me make our deck of cards.
 */
class DeckOfCards
{
    protected array $cards = [];

    /**
     * Constructor.
     *
     * Here we make our deck with the help from the Card and CardGraphic Classes.
     * @return void
     */
    public function __construct(int $amount = 1)
    {
        $values = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
        $suits = ['hearts', 'diamonds', 'clubs', 'spades'];

        for ($i = 1; $i <= $amount; $i++) {
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
    }

    /**
     * method getCards
     *
     * Here we get our playing cards in an array.
     *
     * @return array<int, array{'card': string, 'graphic': string}>
     */
    public function getCards(): array
    {
        return $this->cards;
    }

    /**
     * method getString
     *
     * Here we get our playing cards in string form.
     * We use the Cards class method so it looks like [K, clover].
     *
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
     * method getCard
     *
     * Here we get the utf-8 / our face for our cards.
     * We use the CardGraphic class method for it.
     *
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
     * method getSuit
     *
     * Here we get the suits for our cards.
     *
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

    /**
     * method totalCards
     *
     * Here we get the total amount of cards in our deck.
     *
     * @return int return the total amount of cards.
     */
    public function totalCards(): int
    {
        return count($this->cards);
    }



    /**
     * method drawCard
     *
     * Here we draw cards from our deck, we can pick the amount.
     *
     * @param int $amount
     * @return array<int, array{'suit': string, 'card': string, 'graphic': string}>
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
     * method shuffle
     *
     * Here we shuffle our deck.
     *
     * @return array<int, array{'suit': string, 'card': string, 'graphic': string}>
     */
    public function shuffle(): array
    {
        shuffle($this->cards);
        return $this->cards;
    }


    /**
     * method shuffle
     *
     * Here we shuffle our deck.
     *
     * @return array<int, array{'suit': string, 'card': string, 'graphic': string}>
     */
    //public function multipleDecks(int $amount): array
    //{
    //for ($i = 0; $i < $count; $i++) {
    //$deck = array_merge($deck, $this->createSingleDeck());
    //}
    //return $this->cards;
    //}

}
