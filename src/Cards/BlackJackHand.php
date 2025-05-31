<?php

namespace App\Cards;

/**
 * Class BlackJackHand.
 *
 * here we work and score our hand for our BlackJack game.
 */
class BlackJackHand
{
    /**
     * getScore
     *
     * Here we get a score for our hand, if a card is an Ace or Face cards we give them values.
     *
     * @param array<int, array{'card': string, 'graphic': string}> $hand
     * @return int $acutalscore, we return the score we get for an array (hand).
     */
    public function getScore(array $hand): int
    {
        $actualscore = 0;
        foreach ($hand as $card) {
            $cardValue = $this->extractCardValue($card);
            $score = $this->isRoyal($cardValue);
            if ($actualscore >= 8) {
                if ($cardValue == 'A') {
                    $score = 1;
                }
            } elseif ($cardValue == 'A') {
                $score = 14;
            }
            $actualscore += (int) $score;
        }

        return $actualscore;
    }

    /**
     * extractCardValue
     *
     * Here we take the string for the card and return it,
     * so if we have a king we return K.
     *
     * @param array< string, string> $card
     * @return string
     */
    private function extractCardValue(array $card): string
    {
        $scoreTest = substr($card['card'], 1);
        $score = (explode(",", $scoreTest));
        return $score[0];
    }

    /**
     * isRoyal
     *
     * Here we give values based on face cards.
     *
     * @param string $score
     * @return int $score
     */
    private function isRoyal(string $score): int
    {
        if ($score == 'K') {
            $score = 13;
        } elseif ($score == 'Q') {
            $score = 12;
        } elseif ($score == 'J') {
            $score = 11;
        }
        return (int) $score;
    }


}
