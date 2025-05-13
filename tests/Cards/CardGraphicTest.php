<?php

namespace App\Cards;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class CardGraphicTest extends TestCase
{
    /**
     * Create a card
     */
    public function testCreateCard(): void
    {
        $card = new CardGraphic('2', 'hearts');
        $this->assertInstanceOf("\App\Cards\CardGraphic", $card);

        $this->assertNotEmpty($card);
    }

    /**
     * Create a card
     */
    public function testGetAssString(): void
    {
        $card = new CardGraphic('2', 'hearts');
        $this->assertInstanceOf("\App\Cards\CardGraphic", $card);

        $string = $card->getAsString();

        $this->assertNotEmpty($string);

        $this->assertSame("🂲", $string);
    }


}
