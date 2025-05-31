<?php

namespace App\Project;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class BlackJackTest extends TestCase
{
    /**
     * Create a card
     */
    public function testCreateBank(): void
    {
        $deck = new BlackJack();
        $this->assertInstanceOf("\App\Project\BlackJack", $deck);

        $this->assertNotEmpty($deck);
    }

    /**
     * Create a card
     */
    public function testUsername(): void
    {
        $deck = new BlackJack();
        $this->assertInstanceOf("\App\Project\BlackJack", $deck);

        $deck->setUsername("test");

        $username = $deck->getUsername("test");

        $this->assertNotEmpty($username);

        $this->assertSame("test", $username);
    }


    public function testGetStand(): void
    {
        $deck = new BlackJack();
        $this->assertInstanceOf("\App\Project\BlackJack", $deck);

        $stand = [
            'stand0' => "Go",
            'stand1' => "Go",
            'stand2' => "Go",
        ];

        $stands = $deck->getStand();

        $this->assertNotEmpty($stands);

        $this->assertSame($stand, $stands);
    }


    /**
     * method testPlayers
     *
     * Here we test if we can make multiple "starter"
     * hands for players, in this case we make 2 empty hands
     */
    public function testPlayers(): void
    {
        $deck = new BlackJack();
        $this->assertInstanceOf("\App\Project\BlackJack", $deck);

        $deck->setPlayers(2);

        $players = $deck->getPlayers();

        $deck->setPlayerHands();

        $playerHands = $deck->playerHand();

        //See if the player variable is what we set it to.

        $this->assertNotEmpty($players);
        $this->assertSame(2, $players);

        //Make 2 empty hands and see if they are there

        $this->assertNotEmpty($playerHands);
        $this->assertSame(2, count($playerHands["player"]));
    }


    /**
     * method testDrawCards
     *
     * Here we test to see if we can draw cards for multiple hands
     * We get one card in each hand.
     */
    public function testDrawCards(): void
    {
        $deck = new BlackJack();
        $this->assertInstanceOf("\App\Project\BlackJack", $deck);

        $deck->setPlayers(3);

        $deck -> playerAction("draw0");
        $deck -> playerAction("draw1");
        $deck -> playerAction("draw2");

        $hands = $deck -> playerHand();

        $this->assertNotEmpty($hands);

        $this->assertNotEmpty($hands["player"][0]);
        $this->assertNotEmpty($hands["player"][1]);
        $this->assertNotEmpty($hands["player"][2]);

    }


    /**
     * method testStand
     *
     * Here we check if stand is working / meaning we
     * don't want to draw any more cards.
     * @return void
     */
    public function testStand(): void
    {
        $deck = new BlackJack();
        $this->assertInstanceOf("\App\Project\BlackJack", $deck);

        $deck->setPlayers(1);

        $deck -> playerAction("draw0");
        $deck -> playerAction("stand0");

        $stands = $deck->getStand();


        $this->assertNotEmpty($stands);


        //See if it checks if we "pressed" the stand button
        //meaning we cant draw any more cards
        $this->assertSame("Stop", $stands["stand0"]);

    }



    public function testDealerWin(): void
    {
        $game = new BlackJack();

        $this->assertInstanceOf("\App\Project\BlackJack", $game);


        $player = [
            [ 'suit' => 'clubs', 'card' => '[A, clubs]', 'graphic' => '🃑'],
            [ 'suit' => 'clubs', 'card' => '[7, clubs]', 'graphic' => '🃗']
        ];

        $dealer = [
            [ 'suit' => 'clubs', 'card' => '[10, clubs]', 'graphic' => '🃚'],
            [ 'suit' => 'clubs', 'card' => '[J, clubs]', 'graphic' => '🃛']
        ];

        $game->setPlayerHand($player, 0);

        $game->setDealerHand($dealer);


        $playerHand = $game->playerHand();
        $dealerHand = $game->dealerHand();

        $this->assertNotEmpty($playerHand);
        $this->assertNotEmpty($dealerHand);

        $gameOver = $game -> gameOver();

        $this->assertNotEmpty($gameOver);

        $this->assertSame('Dealer won', $gameOver[0]);
    }


    public function testDrawBlackJackGame(): void
    {
        $game = new BlackJack();

        $this->assertInstanceOf("\App\Project\BlackJack", $game);


        $player = [
            [ 'suit' => 'clubs', 'card' => '[A, hearts]', 'graphic' => '🃑'],
            [ 'suit' => 'clubs', 'card' => '[J, hearts]', 'graphic' => '🃗']
        ];

        $dealer = [
            [ 'suit' => 'clubs', 'card' => '[A, clubs]', 'graphic' => '🃚'],
            [ 'suit' => 'clubs', 'card' => '[J, clubs]', 'graphic' => '🃛']
        ];

        $game->setPlayerHand($player, 0);

        $game->setDealerHand($dealer);


        $playerHand = $game->playerHand();
        $dealerHand = $game->dealerHand();

        $this->assertNotEmpty($playerHand);
        $this->assertNotEmpty($dealerHand);

        $gameOver = $game -> gameOver();

        $this->assertNotEmpty($gameOver);

        $this->assertSame('Draw', $gameOver[0]);
    }


    public function testDrawGame(): void
    {
        $game = new BlackJack();

        $this->assertInstanceOf("\App\Project\BlackJack", $game);


        $player = [
            [ 'suit' => 'clubs', 'card' => '[10, hearts]', 'graphic' => '🃑'],
            [ 'suit' => 'clubs', 'card' => '[J, hearts]', 'graphic' => '🃗']
        ];

        $dealer = [
            [ 'suit' => 'clubs', 'card' => '[10, clubs]', 'graphic' => '🃚'],
            [ 'suit' => 'clubs', 'card' => '[J, clubs]', 'graphic' => '🃛']
        ];

        $game->setPlayerHand($player, 0);

        $game->setDealerHand($dealer);


        $playerHand = $game->playerHand();
        $dealerHand = $game->dealerHand();

        $this->assertNotEmpty($playerHand);
        $this->assertNotEmpty($dealerHand);

        $gameOver = $game -> gameOver();

        $this->assertNotEmpty($gameOver);

        $this->assertSame('Draw', $gameOver[0]);
    }


    public function testPlayerWon(): void
    {
        $game = new BlackJack();

        $this->assertInstanceOf("\App\Project\BlackJack", $game);


        $player = [
            [ 'suit' => 'clubs', 'card' => '[K, hearts]', 'graphic' => '🃑'],
            [ 'suit' => 'clubs', 'card' => '[J, hearts]', 'graphic' => '🃗'],
            [ 'suit' => 'clubs', 'card' => '[A, hearts]', 'graphic' => '🃑']
        ];

        $dealer = [
            [ 'suit' => 'clubs', 'card' => '[10, clubs]', 'graphic' => '🃚'],
            [ 'suit' => 'clubs', 'card' => '[J, clubs]', 'graphic' => '🃛']
        ];

        $game->setPlayerHand($player, 0);

        $game->setDealerHand($dealer);


        $playerHand = $game->playerHand();
        $dealerHand = $game->dealerHand();

        $this->assertNotEmpty($playerHand);
        $this->assertNotEmpty($dealerHand);

        $gameOver = $game -> gameOver();

        $this->assertNotEmpty($gameOver);

        $this->assertSame('Player won', $gameOver[0]);
    }


    public function testDealerBlackJackWon(): void
    {
        $game = new BlackJack();

        $this->assertInstanceOf("\App\Project\BlackJack", $game);


        $player = [
            [ 'suit' => 'clubs', 'card' => '[10, hearts]', 'graphic' => '🃑'],
            [ 'suit' => 'clubs', 'card' => '[J, hearts]', 'graphic' => '🃗']
        ];

        $dealer = [
            [ 'suit' => 'clubs', 'card' => '[A, clubs]', 'graphic' => '🃚'],
            [ 'suit' => 'clubs', 'card' => '[J, clubs]', 'graphic' => '🃛']
        ];

        $game->setPlayerHand($player, 0);

        $game->setDealerHand($dealer);


        $playerHand = $game->playerHand();
        $dealerHand = $game->dealerHand();

        $this->assertNotEmpty($playerHand);
        $this->assertNotEmpty($dealerHand);

        $gameOver = $game -> gameOver();

        $this->assertNotEmpty($gameOver);

        $this->assertSame('Dealer won', $gameOver[0]);
    }


    public function testPlayerBust(): void
    {
        $game = new BlackJack();

        $this->assertInstanceOf("\App\Project\BlackJack", $game);


        $player = [
            [ 'suit' => 'clubs', 'card' => '[10, hearts]', 'graphic' => '🃑'],
            [ 'suit' => 'clubs', 'card' => '[J, hearts]', 'graphic' => '🃗'],
            [ 'suit' => 'clubs', 'card' => '[K, hearts]', 'graphic' => '🃗']
        ];

        $dealer = [
            [ 'suit' => 'clubs', 'card' => '[10, clubs]', 'graphic' => '🃚'],
            [ 'suit' => 'clubs', 'card' => '[J, clubs]', 'graphic' => '🃛']
        ];

        $game->setPlayerHand($player, 0);

        $game->setDealerHand($dealer);


        $playerHand = $game->playerHand();
        $dealerHand = $game->dealerHand();

        $this->assertNotEmpty($playerHand);
        $this->assertNotEmpty($dealerHand);

        $gameOver = $game -> gameOver();

        $this->assertNotEmpty($gameOver);

        $this->assertSame('Dealer won', $gameOver[0]);
    }


    public function testDealerBust(): void
    {
        $game = new BlackJack();

        $this->assertInstanceOf("\App\Project\BlackJack", $game);


        $player = [
            [ 'suit' => 'clubs', 'card' => '[10, hearts]', 'graphic' => '🃑'],
            [ 'suit' => 'clubs', 'card' => '[J, hearts]', 'graphic' => '🃗']
        ];

        $dealer = [
            [ 'suit' => 'clubs', 'card' => '[10, clubs]', 'graphic' => '🃚'],
            [ 'suit' => 'clubs', 'card' => '[J, clubs]', 'graphic' => '🃛'],
            [ 'suit' => 'clubs', 'card' => '[K, hearts]', 'graphic' => '🃗']
        ];

        $game->setPlayerHand($player, 0);

        $game->setDealerHand($dealer);


        $playerHand = $game->playerHand();
        $dealerHand = $game->dealerHand();

        $this->assertNotEmpty($playerHand);
        $this->assertNotEmpty($dealerHand);

        $gameOver = $game -> gameOver();

        $this->assertNotEmpty($gameOver);

        $this->assertSame('Player won', $gameOver[0]);
    }



    public function testPlayerNormalWin(): void
    {
        $game = new BlackJack();

        $this->assertInstanceOf("\App\Project\BlackJack", $game);


        $player = [
            [ 'suit' => 'clubs', 'card' => '[10, hearts]', 'graphic' => '🃑'],
            [ 'suit' => 'clubs', 'card' => '[Q, hearts]', 'graphic' => '🃗']
        ];

        $dealer = [
            [ 'suit' => 'clubs', 'card' => '[10, clubs]', 'graphic' => '🃚'],
            [ 'suit' => 'clubs', 'card' => '[7, clubs]', 'graphic' => '🃛'],
        ];

        $game->setPlayerHand($player, 0);

        $game->setDealerHand($dealer);


        $playerHand = $game->playerHand();
        $dealerHand = $game->dealerHand();

        $this->assertNotEmpty($playerHand);
        $this->assertNotEmpty($dealerHand);

        $gameOver = $game -> gameOver();

        $this->assertNotEmpty($gameOver);

        $this->assertSame('Player won', $gameOver[0]);
    }



    public function testNoScore(): void
    {
        $game = new BlackJack();

        $this->assertInstanceOf("\App\Project\BlackJack", $game);

        $game -> drawCard("dealer");
        $game->setPlayers(2);
        $game->setPlayerHands();

        $gameOver = $game -> gameOver();

        $this->assertNotEmpty($gameOver);

        $this->assertSame('No Score', $gameOver[0]);
    }


    public function testDealerDrawMultiple(): void
    {
        $game = new BlackJack();

        $this->assertInstanceOf("\App\Project\BlackJack", $game);

        $stand = [
            'stand0' => "Stop",
            'stand1' => "Stop",
            'stand2' => "Stop",
        ];

        $game -> drawCard("dealer");

        $game->setPlayers(3);

        $game -> playerAction("draw0");
        $game -> playerAction("draw1");
        $game -> playerAction("draw2");

        $game -> playerAction("stand0");
        $game -> playerAction("stand1");
        $game -> playerAction("stand2");

        $dealerTurn = $game -> dealersTurn();


        print_r($dealerTurn);

        $this->assertNotEmpty($dealerTurn);

        $this->assertSame("Start", $dealerTurn);

    }


    public function testNotDealersTurn(): void
    {
        $game = new BlackJack();

        $this->assertInstanceOf("\App\Project\BlackJack", $game);

        $stand = [
            'stand0' => "Stop",
            'stand1' => "Stop",
            'stand2' => "Stop",
        ];

        $game -> drawCard("dealer");

        $game->setPlayers(3);

        $game -> playerAction("draw0");
        $game -> playerAction("draw1");
        $game -> playerAction("draw2");

        $game -> playerAction("stand0");
        $game -> playerAction("stand1");

        $dealerTurn = $game -> dealersTurn();


        print_r($dealerTurn);

        $this->assertNotEmpty($dealerTurn);

        $this->assertSame("dontDraw", $dealerTurn);

    }


    public function testStoppingBustedHand(): void
    {
        $game = new BlackJack();

        $this->assertInstanceOf("\App\Project\BlackJack", $game);

        $stand = [
            'stand0' => "Stop",
            'stand1' => "Stop",
            'stand2' => "Stop",
        ];

        $game -> drawCard("dealer");

        $game->setPlayers(3);

        $game -> playerAction("draw0");
        $game -> playerAction("draw1");
        $game -> playerAction("draw2");
        $game -> playerAction("draw2");
        $game -> playerAction("draw2");
        $game -> playerAction("draw2");

        $game -> playerAction("stand0");
        $game -> playerAction("stand1");

        $dealerTurn = $game -> dealersTurn();


        print_r($dealerTurn);

        $this->assertNotEmpty($dealerTurn);

        $this->assertSame("Start", $dealerTurn);

    }







}
