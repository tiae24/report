<?php

namespace App\Cards;

use App\Cards\DeckOfCards;
use App\Cards\BlackJackHand;
use App\Cards\BlackJackWinner;

/**
 * Class BlackJack.
 * 
 * Here is everything for the game, from drawing a card, to scoring a hand.
 */
class BlackJack
{
    /** @var DeckOfCards */
    protected $deck;

    /** @var BlackJackHand */
    protected $hand;

    /** @var BlackJackWinner */
    protected $winner;

    /** 
     * @var array<int, array{ suit: string, card: string, graphic: string }> 
    */
    protected $playerHand = [];

    /** @var array<int, array{ suit: string, card: string, graphic: string }> */
    protected $dealerHand = [];


    /**
     * Constructor.
     * 
     * Here we get out Deck, and Classes that we use to get scores and winners.
     * @return void
     */
    public function __construct()
    {
        $this->deck = new DeckOfCards();
        $this->hand = new BlackJackHand();
        $this->winner = new BlackJackWinner();
    }

    /**
     * Here is where we get score for the players and dealers hand
     * With an ace and the face cards we give them a numerical value instead.
     * @param array<int, array{ card: string, graphic: string }> $hand
     * @return int $score. Which is the score for a hand.
     */
    public function getScore(array $hand): int
    {
        $score = $this->hand->getScore($hand);

        return $score;
    }

    /**
     * Here is where we draw a card to add to the hand of either the player or dealer.
     * our parameter is where we write if we are the player or dealer so we know where to add the cards
     * If we are the dealer we loop until our hand is worth atleast 17.
     * @param string $player
     * @return array<int, array{ suit: string, card: string, graphic: string }>
     */
    public function drawCard(string $player): array
    {
        $hand = [];

        $drawn = $this->deck -> drawCard(1);
        if ($player == 'player') {
            $this->playerHand[] = $drawn[0];

            $hand =  $this->playerHand;

        } elseif ($player == 'dealer') {
            while ($this->getScore($this->dealerHand) <= 17) {
                $drawn2 = $this->deck -> drawCard(1);

                $this->dealerHand[] = $drawn2[0];
            }

            $hand =  $this->dealerHand;

        }

        return $hand;
    }


    /**
     * Here is where we return our player hand.
     * @return array<int, array{ card: string, graphic: string }> */
    public function playerHand(): array
    {
        return $this->playerHand;
    }

    /**
     * Here is where we return our dealer hand.
     * @return array<int, array{ card: string, graphic: string }> */
    public function dealerHand(): array
    {
        return $this->dealerHand;
    }

    /**
     * Here is where we check the state of our game and see which player won.
     * @return string Here it says either "player won" or "dealer won" */
    public function gameOver(): string
    {
        $playerScore = $this->getScore($this->playerHand);
        $dealerScore = $this->getScore($this->dealerHand);

        $winner = $this->winner->gameOver($dealerScore, $playerScore);

        return $winner;

    }





    /**
     * I used this for the test and its where we can decide how our players hand should look.
     * @param array<int, array{suit: string, card: string, graphic: string}> $hand
     * @return array<int, array{ card: string, graphic: string }> */
    public function setPlayerHand(array $hand): array
    {
        $this->playerHand = $hand;
        return $this->playerHand;
    }


    /**
     * I used this for the test and its where we can decide how our dealers hand should look.
     * @param array<int, array{suit: string, card: string, graphic: string}> $hand
     * @return array<int, array{ card: string, graphic: string }> */
    public function setDealerHand(array $hand): array
    {
        $this->dealerHand = $hand;
        return $this->dealerHand;
    }


}
