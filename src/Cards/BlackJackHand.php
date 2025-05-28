<?php

namespace App\Cards;

class BlackJackHand
{
    /**
     * @param array<int, array{'card': string, 'graphic': string}> $hand
     * @return int $acutalscore, we return the score we get for an array (hand).
     */
    public function getScore(array $hand): int
    {
        $actualscore = 0;
        foreach ($hand as $card) {
            $score = $this->extractCardValue($card);
            $score = $this->isRoyal($score);
            if ($actualscore >= 8) {
                if ($score == 'A') {
                    $score = 1;
                }
            } elseif ($score == 'A') {
                $score = 14;
            }
            $actualscore += (int) $score;
        }

        return $actualscore;
    }

    /**
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
     * @param string $score
     */
    private function isRoyal(string $score)
    {
        if ($score == 'K') {
            $score = 13;
        } elseif ($score == 'Q') {
            $score = 12;
        } elseif ($score == 'J') {
            $score = 11;
        }
        return $score;
    }


}
