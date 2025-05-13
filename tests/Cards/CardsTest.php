<?php

namespace App\Cards;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class CardsTest extends TestCase
{
    /**
     * Create a card
     */
    public function testCreateCard(): void
    {
        $card = new Cards('2', 'hearts');
        $this->assertInstanceOf("\App\Cards\Cards", $card);

        $this->assertNotEmpty($card);
    }


    /**
     * Test to see if getting our card value works
     */
    public function testCardValue(): void
    {
        $card = new Cards('2', 'hearts');
        $this->assertInstanceOf("\App\Cards\Cards", $card);

        $res = $card->getValue();
        //print_r($res);
        $this->assertNotEmpty($res);

        //Check to see if we get our correct value back
        $this->assertSame('2', $res);

        //Check if it works to get the int value
        $this->assertSame(2, (int) $res);
    }

    /**
     * Test to see if getting our card suit works
     */
    public function testCardSuit(): void
    {
        $card = new Cards('2', 'hearts');
        $this->assertInstanceOf("\App\Cards\Cards", $card);

        $res = $card->getSuit();
        //print_r($res);
        $this->assertNotEmpty($res);

        //Check to see if we get our correct value back
        $this->assertSame('hearts', $res);
    }


    /**
     * Test to see if we can get the whole card as a string.
     */
    public function testGetString(): void
    {
        $card = new Cards('2', 'hearts');
        $this->assertInstanceOf("\App\Cards\Cards", $card);

        $res = $card->getAsString();
        $this->assertNotEmpty($res);

        //Check to see if we can get the card as a string.
        $this->assertSame('[2, hearts]', $res);

        //Check to see if type is a string
        $this->assertSame('string', gettype($res));
    }
}
