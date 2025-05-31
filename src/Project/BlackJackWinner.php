<?php

namespace App\Project;

/**
 * Class BlackJackWinner.
 *
 * Here we determine who wins our game of BlackJack.
 */
class BlackJackWinner
{
    /**
     * method gameOver
     *
     * Here is where we check the state of our game and see which player won.
     * @return string */
    public function gameOver(int $dealerScore, int $playerScore): string
    {

        if ($this->hasBlackJack($dealerScore)) {
            if ($this->isDraw($playerScore, $dealerScore)) {
                return 'Draw';
            }
            return 'Dealer won';
        }
        if ($this->hasBlackJack($playerScore)) {
            return 'Player won';
        }

        if ($this->hasBust($playerScore)) {
            return 'Dealer won';
        }

        if ($this->hasBust($dealerScore)) {
            return 'Player won';
        }


        if ($dealerScore >= 17) {
            return ($this->BlackJackWinner($playerScore, $dealerScore));
        }

        return 'No Score';
    }

    /**
     * method BlackJackWinner
     *
     * @param int $dealerScore
     * @param int $playerScore
     * @return string This is for if the dealer has stopped drawing, we check who has the higher score.
     */
    private function BlackJackWinner(int $playerScore, $dealerScore): string
    {
        if ($this->isDraw($playerScore, $dealerScore)) {
            return 'Draw';
        } elseif ($playerScore > $dealerScore) {
            return 'Player won';
        } elseif ($dealerScore > $playerScore) {
            return 'Dealer won';
        }
    }

    /**
     * method hasBlackJack
     *
     * Check if someone got BlackJack.
     * @return bool Return True if the score is 21 and gives blackjack.
     */
    private function hasBlackJack(int $score): bool
    {
        return $score == 21;
    }

    /**
     * method hasBust
     *
     * Check if someones hand bust.
     * @return bool Return True if someones score is over 21, their hand bust.
     */
    private function hasBust(int $score): bool
    {
        return $score > 21;
    }


    private function isDraw(int $player, int $dealer): bool
    {
        return $player == $dealer;
    }



}
