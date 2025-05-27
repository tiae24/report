<?php

namespace App\Cards;

class BlackJackHand
{

    /**
     * @param array<int, array{ card: string, graphic: string }> $hand
     * @return int $acutalscore, we return the score we get for an array (hand).
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


}
