<?php

namespace App\Project;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class BankTest extends TestCase
{
    /**
     * Create a card
     */
    public function testCreateBank(): void
    {
        $bank = new Bank(1);
        $this->assertInstanceOf("\App\Project\Bank", $bank);

        $this->assertNotEmpty($bank);
    }

    /**
     * Create a card
     */
    public function testGetBalance(): void
    {
        $bank = new Bank(1);
        $this->assertInstanceOf("\App\Project\Bank", $bank);

        $balance = $bank->getBalance();

        $this->assertNotEmpty($balance);

        $this->assertSame(1000, $balance);
    }


    public function testPlaceBets(): void
    {
        $bank = new Bank(2);
        $this->assertInstanceOf("\App\Project\Bank", $bank);

        $bank->placeBet(0, 25);
        $afford = $bank->placeBet(1, 1001);

        $bets = $bank->getBets();

        $this->assertNotEmpty($bets);

        $this->assertSame(25, $bets[0]);

    }



    public function testGamblingOutcome(): void
    {
        $bank = new Bank(3);
        $this->assertInstanceOf("\App\Project\Bank", $bank);

        $winners = [
            "Player won",
            "Dealer won",
            "Draw"
        ];

        $bank->placeBet(0, 25);
        $bank->placeBet(1, 25);
        $bank->placeBet(2, 25);


        $Won = $bank->gamblingOutcome($winners);

        $this->assertNotEmpty($Won);

        $this->assertSame(50, $Won[0]);
        $this->assertSame(0, $Won[1]);
        $this->assertSame(25, $Won[2]);

    }



}
