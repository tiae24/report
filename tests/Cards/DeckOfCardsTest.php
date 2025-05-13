<?php

namespace App\Cards;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DeckOfCardsTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateDeck(): void
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\App\Cards\DeckOfCards", $deck);

        $res = $deck->getCards();
        $this->assertNotEmpty($res);
    }

    public function testGetString(): void
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\App\Cards\DeckOfCards", $deck);

        $res = $deck->getString();
        $this->assertNotEmpty($res);
    }

    /**
     * Get the total amount of cards in the deck.
     */
    public function testDrawCard(): void
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\App\Cards\DeckOfCards", $deck);

        $res = $deck->drawCard(1);
        $this->assertNotEmpty($res);

        //check to see if size decreases

        $res2 = $deck->totalCards();
        $this->assertSame(51, $res2);
    }

    /**
     * Get the total amount of cards in the deck.
     */
    public function testTotalCards(): void
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\App\Cards\DeckOfCards", $deck);

        $res = $deck->totalCards();
        $this->assertSame(52, $res);
    }


    public function testGetCard(): void
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\App\Cards\DeckOfCards", $deck);

        $res = $deck->getCard();

        //Makes sure we get all cards, so 13 for each suit

        $this->assertNotEmpty($res);

        //Testing that the we get the first and last card
        $this->assertSame("🂲", $res[0]);
        $this->assertSame("🂡", $res[51]);
    }


    /**
     * Get the total amount of cards in the deck.
     */
    public function testGetSuit(): void
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\App\Cards\DeckOfCards", $deck);

        $res = $deck->getSuit();

        //Makes sure we get all cards, so 13 for each suit

        $counted = array_count_values($res);

        //print_r($counted['spades']);

        $this->assertSame(13, $counted['hearts']);
        $this->assertSame(13, $counted['diamonds']);
        $this->assertSame(13, $counted['clubs']);
        $this->assertSame(13, $counted['spades']);
    }

    /**
     * Get the total amount of cards in the deck.
     */
    public function testShuffle(): void
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\App\Cards\DeckOfCards", $deck);

        $newDeck = clone $deck;

        $shuffle = $newDeck->shuffle();

        $res = $deck->getCards();
        $resShuffled = $newDeck->getCards();
        $this->assertNotSame($resShuffled, $res);
    }
}
