<?php

namespace App\Cards;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class BlackJackTest extends TestCase
{
    /**
     * Create a card
     */
    public function testStartGame(): void
    {
        $deck = new BlackJack();
        $this->assertInstanceOf("\App\Cards\BlackJack", $deck);

        $this->assertNotEmpty($deck);
    }

    /**
     * Create a card
     */
    public function testDrawCard(): void
    {
        $deck = new BlackJack();
        $this->assertInstanceOf("\App\Cards\BlackJack", $deck);

        $drawnCard = $deck->drawCard("player");

        $this->assertNotEmpty($drawnCard);
    }

    public function testPlayerHand(): void
    {
        $deck = new BlackJack();
        $this->assertInstanceOf("\App\Cards\BlackJack", $deck);

        $drawnCard = $deck->drawCard("player");

        $playerHand = $deck->playerHand();

        //Make sure the hand gets created, the card we drew is the same
        //as the one in the hand and that the size is correct

        $this->assertNotEmpty($playerHand);
        $this->assertSame($drawnCard, $playerHand);
        $this->assertSame(1, count($deck->playerHand()));

        $deck->drawCard("player");
        $deck->drawCard("player");

        //print_r($deck->playerHand());
        //print_r(count($deck->playerHand()));

        $handCount = count($deck->playerHand());

        //Try to draw multiple cards and see if they get added
        $this->assertSame(3, $handCount);

    }

    public function testDealerHand()
    {
        $deck = new BlackJack();
        $this->assertInstanceOf("\App\Cards\BlackJack", $deck);

        $drawnCard = $deck->drawCard("dealer");

        $dealerHand = $deck->dealerHand();

        //Make sure the hand gets created, the card we drew is the same

        $this->assertNotEmpty($dealerHand);
        $this->assertSame($drawnCard, $dealerHand);

        //Since the dealerHand is always bigger than 1 card we check to see that it works
        $this->assertNotSame(1, count($dealerHand));
    }


    public function testGetScore(): void
    {
        $deck = new BlackJack();
        $this->assertInstanceOf("\App\Cards\BlackJack", $deck);

        $hand = [
            [ 'suit' => 'clubs','card' => '[K, clubs]', 'graphic' => '🃞'],
            [ 'suit' => 'clubs', 'card' => '[Q, clubs]', 'graphic' => '🃝'],
            [ 'suit' => 'clubs', 'card' => '[J, clubs]', 'graphic' => '🃛'],
            [ 'suit' => 'clubs', 'card' => '[A, clubs]', 'graphic' => '🃑']
        ];

        $aceHand2 = [
            [ 'suit' => 'clubs', 'card' => '[A, clubs]', 'graphic' => '🃑'],
            [ 'suit' => 'clubs','card' => '[K, clubs]', 'graphic' => '🃞'],
            [ 'suit' => 'clubs', 'card' => '[Q, clubs]', 'graphic' => '🃝'],
            [ 'suit' => 'clubs', 'card' => '[J, clubs]', 'graphic' => '🃛']
        ];

        $aceHand = [
            [ 'suit' => 'clubs', 'card' => '[A, clubs]', 'graphic' => '🃑']
        ];


        $score = $deck->getScore($hand);

        $aceScore = $deck->getScore($aceHand2);

        $aceScore2 = $deck->getScore($aceHand);

        $this->assertNotEmpty($score);
        $this->assertNotEmpty($aceScore);
        $this->assertNotEmpty($aceScore2);

        //checks if the score for all the "special" cards is 37 combined
        //36 for the face cards and + 1 since the ace is added when they hand was about to bust
        //hence making it 1

        $this->assertSame(37, $score);
        $this->assertSame(14, $aceScore2);

        //Now if we have the same hand with all the "special" cards but the ace is added first
        //the value should be 14 for the ace and 50 in total, since the cards is added before it cant
        //bust the hand
        $this->assertSame(50, $aceScore);


    }


    public function testDealerGetScore(): void
    {
        $deck = new BlackJack();
        $this->assertInstanceOf("\App\Cards\BlackJack", $deck);

        $deck->drawCard("dealer");

        $dealerHand = $deck->dealerHand();

        $dealerScore = $deck->getScore($dealerHand);

        //Check to see if the score is bigger than 16
        //since the dealer will always get atleast 17

        $this->assertNotEmpty($dealerScore);

        $this->assertGreaterThan(16, $dealerScore);

    }


    public function testGetPlayerScore(): void
    {
        $deck = new BlackJack();
        $this->assertInstanceOf("\App\Cards\BlackJack", $deck);

        $deck->drawCard("player");

        $playerHand = $deck->playerHand();

        $playerScore = $deck->getScore($playerHand);

        $this->assertNotEmpty($playerScore);
    }

    public function testNoScore(): void
    {
        $deck = new BlackJack();
        $this->assertInstanceOf("\App\Cards\BlackJack", $deck);

        $game = $deck->gameOver();

        $this->assertNotEmpty($game);
        $this->assertSame('No Score', $game);
    }


    public function testGame21(): void
    {
        $player21 = new BlackJack();
        $dealer21 = new BlackJack();
        $this->assertInstanceOf("\App\Cards\BlackJack", $player21);
        $this->assertInstanceOf("\App\Cards\BlackJack", $dealer21);

        $testHand2 = [
            [ 'suit' => 'clubs', 'card' => '[A, clubs]', 'graphic' => '🃑'],
            [ 'suit' => 'clubs', 'card' => '[7, clubs]', 'graphic' => '🃗']
        ];

        $testHand = [
            [ 'suit' => 'clubs', 'card' => '[10, clubs]', 'graphic' => '🃚'],
            [ 'suit' => 'clubs', 'card' => '[J, clubs]', 'graphic' => '🃛']
        ];

        $player21->setPlayerHand($testHand2);

        $dealer21->setDealerHand($testHand);


        $playerHand = $player21->playerHand();
        $dealerHand = $dealer21->dealerHand();

        $this->assertNotEmpty($playerHand);
        $this->assertNotEmpty($dealerHand);

        $playerGame = $player21 -> gameOver();
        $dealerGame = $dealer21 -> gameOver();

        $this->assertNotEmpty($playerGame);
        $this->assertNotEmpty($dealerGame);

        $this->assertSame('Player won', $playerGame);
        $this->assertSame('Dealer won', $dealerGame);
    }


    public function testGameBust(): void
    {
        $player21 = new BlackJack();
        $dealer21 = new BlackJack();
        $this->assertInstanceOf("\App\Cards\BlackJack", $player21);
        $this->assertInstanceOf("\App\Cards\BlackJack", $dealer21);

        $testHand2 = [
            [ 'suit' => 'clubs', 'card' => '[A, clubs]', 'graphic' => '🃑'],
            [ 'suit' => 'clubs', 'card' => '[K, clubs]', 'graphic' => '🃞']
        ];

        $testHand = [
            [ 'suit' => 'clubs', 'card' => '[10, clubs]', 'graphic' => '🃚'],
            [ 'suit' => 'clubs', 'card' => '[K, clubs]', 'graphic' => '🃞']
        ];

        $player21->setPlayerHand($testHand2);

        $dealer21->setDealerHand($testHand);

        $playerHand = $player21->playerHand();
        $dealerHand = $dealer21->dealerHand();

        $this->assertNotEmpty($playerHand);
        $this->assertNotEmpty($dealerHand);

        $playerGame = $player21 -> gameOver();
        $dealerGame = $dealer21 -> gameOver();

        $this->assertNotEmpty($playerGame);
        $this->assertNotEmpty($dealerGame);

        $this->assertSame('Dealer won', $playerGame);
        $this->assertSame('Player won', $dealerGame);

    }


    public function testGameSameValue(): void
    {
        $deck = new BlackJack();
        $this->assertInstanceOf("\App\Cards\BlackJack", $deck);

        $testHand2 = [
            [ 'suit' => 'clubs', 'card' => '[10, clubs]', 'graphic' => '🃚'],
            [ 'suit' => 'clubs', 'card' => '[8, clubs]', 'graphic' => '🃘']
        ];

        $testHand = [
            [ 'suit' => 'clubs', 'card' => '[10, clubs]', 'graphic' => '🃚'],
            [ 'suit' => 'clubs', 'card' => '[8, clubs]', 'graphic' => '🃘']
        ];

        $deck->setPlayerHand($testHand2);

        $deck->setDealerHand($testHand);

        $playerHand = $deck->playerHand();
        $dealerHand = $deck->dealerHand();

        $this->assertNotEmpty($playerHand);
        $this->assertNotEmpty($dealerHand);

        $game = $deck -> gameOver();

        $this->assertNotEmpty($game);
        $this->assertNotEmpty($game);

        $this->assertSame('Dealer won', $game);

    }


    public function testPlayerWin(): void
    {
        $deck = new BlackJack();
        $this->assertInstanceOf("\App\Cards\BlackJack", $deck);

        $testHand2 = [
            [ 'suit' => 'clubs', 'card' => '[10, clubs]', 'graphic' => '🃚'],
            [ 'suit' => 'clubs', 'card' => '[9, clubs]', 'graphic' => '🃙']
        ];

        $testHand = [
            [ 'suit' => 'clubs', 'card' => '[10, clubs]', 'graphic' => '🃚'],
            [ 'suit' => 'clubs', 'card' => '[8, clubs]', 'graphic' => '🃘']
        ];

        $deck->setPlayerHand($testHand2);

        $deck->setDealerHand($testHand);

        $playerHand = $deck->playerHand();
        $dealerHand = $deck->dealerHand();

        $this->assertNotEmpty($playerHand);
        $this->assertNotEmpty($dealerHand);

        $playerGame = $deck -> gameOver();
        $dealerGame = $deck -> gameOver();

        $this->assertNotEmpty($playerGame);
        $this->assertNotEmpty($dealerGame);

        $this->assertSame('Player won', $dealerGame);

    }


    public function testDealerWin(): void
    {
        $deck = new BlackJack();
        $this->assertInstanceOf("\App\Cards\BlackJack", $deck);

        $testHand2 = [
            [ 'suit' => 'clubs', 'card' => '[10, clubs]', 'graphic' => '🃚'],
            [ 'suit' => 'clubs', 'card' => '[8, clubs]', 'graphic' => '🃘']
        ];

        $testHand = [
            [ 'suit' => 'clubs', 'card' => '[10, clubs]', 'graphic' => '🃚'],
            [ 'suit' => 'clubs', 'card' => '[9, clubs]', 'graphic' => '🃙']
        ];

        $deck->setPlayerHand($testHand2);

        $deck->setDealerHand($testHand);

        $playerHand = $deck->playerHand();
        $dealerHand = $deck->dealerHand();

        $this->assertNotEmpty($playerHand);
        $this->assertNotEmpty($dealerHand);

        $playerGame = $deck -> gameOver();
        $dealerGame = $deck -> gameOver();

        $this->assertNotEmpty($playerGame);
        $this->assertNotEmpty($dealerGame);

        $this->assertSame('Dealer won', $dealerGame);

    }

}
