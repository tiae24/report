<?php

namespace App\Project;

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
        $this->assertInstanceOf("\App\Project\CardGraphic", $card);

        $this->assertNotEmpty($card);
    }

    /**
     * Create a card
     */
    public function testGetAssString(): void
    {
        $card = new CardGraphic('2', 'hearts');
        $this->assertInstanceOf("\App\Project\CardGraphic", $card);

        $string = $card->getAsString();

        $this->assertNotEmpty($string);

        $this->assertSame("🂲", $string);
    }


}
