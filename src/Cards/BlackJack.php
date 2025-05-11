<?php

namespace App\Cards;

use App\Cards\Cards;
use App\Cards\CardGraphic;
use App\Cards\DeckOfCards;

class BlackJack
{
    /** @var DeckOfCards */
    protected $deck;

    /** @var array<int, array{ suit: string, card: string, graphic: string }> */
    protected $playerHand = [];

    /** @var array<int, array{ suit: string, card: string, graphic: string }> */
    protected $dealerHand = [];


    public function __construct()
    {
        $this->deck = new DeckOfCards();
    }

    /**
     * @param array<int, array{ card: string, graphic: string }> $hand
     * @return int
     */
    public function getScore(array $hand): int
    {
        $score = "";
        $actualscore = 0;
        foreach ($hand as $card) {
            $scoreTest = substr($card['card'], 1);
            $score = (explode(",", $scoreTest));
            if ($score[0] == 'K') {
                $score[0] = 13;
            } elseif ($score[0] == 'Q') {
                $score[0] = 12;
            } elseif ($score[0] == 'J') {
                $score[0] = 11;
            } elseif ($actualscore >= 8) {
                if ($score[0] == 'A') {
                    $score[0] = 1;
                }
            } elseif ($score[0] == 'A') {
                $score[0] = 14;
            }
            $actualscore += (int) $score[0];
        }

        return $actualscore;
    }

    /**
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


    /** @return array<int, array{ card: string, graphic: string }> */
    public function playerHand(): array
    {
        return $this->playerHand;
    }

    /** @return array<int, array{ card: string, graphic: string }> */
    public function dealerHand(): array
    {
        return $this->dealerHand;
    }

    /** @return string */
    public function gameOver(): string
    {
        $playerScore = $this->getScore($this->playerHand);
        $dealerScore = $this->getScore($this->dealerHand);

        if ($playerScore == 21) {
            return 'Player won';
        } elseif ($dealerScore == 21) {
            return 'Player won';
        }

        if ($playerScore > 21) {
            return 'Dealer won';
        } elseif ($dealerScore > 21) {
            return 'Player won';
        }

        if ($dealerScore >= 17) {
            if ($playerScore > $dealerScore) {
                return 'Player won';
            } elseif ($dealerScore > $playerScore) {
                return 'Dealer won';
            } elseif ($dealerScore == $playerScore) {
                return 'Dealer won';
            }
        }

        return 'No Score';
    }



}
