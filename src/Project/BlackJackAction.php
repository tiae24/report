<?php

namespace App\Project;

/**
 * Class BlackJackAction.
 *
 * here we work and score our hand for our BlackJack game.
 */
class BlackJackAction
{
    /**
     * getScore
     *
     * Here we get a score for our hand, if a card is an Ace or Face cards we give them values.
     *
     * @param array <string, string> $stand
     * @param string $index
     * @return array <string, string> $stand
     */
    public function action(array $stand, string $index): array
    {
        $stand[$index] = "Stop";

        return $stand;
    }


    /**
     * method stopHand
     * 
     * Here to stop a players ability to hit if they bust
     * or when you win
     * 
     * @param array <string> $game
     * @param array <string, string> $stand
     * @return array <string, string> $stand
     */
    public function stopHand(array $game, array $stand): array
    {

        for ($i = 0; $i < count($game); $i++) {
            if ($game[$i] === 'Dealer won' || $game[$i] === 'Player won' || $game[$i] === 'Draw') {
                $stand["stand" . $i] = "Stop";
            }
        }
        return $stand;

    }


    /**
     * method dealersTurn
     * 
     * Here to stop a players ability to hit if they bust
     * or when you win
     * 
     * @param array <string> $game
     * @param array <string, string> $stand
     * @return string "dontDraw" or "draw"
     */
    public function dealersTurn(array $game, array $stand): string
    {
        $stopped = 0;

        for ($i = 0; $i < count($game); $i++) {
            if ($stand["stand" . $i] === 'Stop') {
                $stopped += 1;
            }
        }

        if ($stopped == count($game)) {
            return "draw";
        }

        return "dontDraw";

    }




}
