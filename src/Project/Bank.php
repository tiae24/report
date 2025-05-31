<?php

namespace App\Project;

use App\Project\DeckOfCards;
use App\Project\BlackJackHand;
use App\Project\BlackJackWinner;

/**
 * Class Bank.
 *
 * Here is everything for the game, from drawing a card, to scoring a hand.
 */
class Bank
{
    private int $balance;
    /** @var array<int, int|string> */
    private $bets = [];
    /** @var array<int, int|string>*/
    private $winners = [];

    /**
     * Constructor.
     *
     * Here we make our bank.
     * We make our starter balance and how many players are gonna place bets.
     */
    public function __construct(int $players, int $startBalance = 1000)
    {
        $this->balance = $startBalance;
        for ($i = 0; $i < $players; $i++) {
            $this->bets[$i] = 0;
        }
        for ($i = 0; $i < $players; $i++) {
            $this->winners[$i] = 0;
        }
    }

    /**
     * method placeBet
     *
     * Here is where we place a bet, we can only make it if we have enough money.
     * @return void
     */
    public function placeBet(int $index, int $placedBet): void
    {
        if ($placedBet < $this->balance) {
            $this->balance -= $placedBet;
            $this->bets[$index] = $placedBet;
        }

    }

    /**
     * method gamblingOutcome
     *
     * Here we distribute the bets, we check if a bet,
     * won, lost or it was a draw.
     * @param array <int, string> $winner
     * @return array <int, int|string> $winners
     */
    public function gamblingOutcome(array $winner): array
    {
        $winners = $this->winners;
        for ($i = 0; $i < count($winner); $i++) {
            if ($winner[$i] == 'Player won') {
                $winners[$i] = $this->gamblingWinner($i);
            } elseif ($winner[$i] == 'Dealer won') {
                $winners[$i] = $this->gamblingLoser($i);
            } elseif ($winner[$i] == 'Draw') {
                $winners[$i] = $this->gamblingDraw($i);
            }
        }
        $this->winners = $winners;
        return $winners;

    }

    /**
     * method gamblingWinner
     *
     * Here we do the stuff for a winner,
     * add money to balance.
     *
     * @return int $placedBet
     */
    public function gamblingWinner(int $index): int
    {
        $placedBet = $this->bets[$index];
        $placedBet = (int) $placedBet + (int) $placedBet;
        $this->balance += (int) $placedBet;

        return $placedBet;
    }


    /**
     * method gamblingLoser
     *
     * Here we return 0 since if you lose you lose all your money.
     *
     * @return int
     */
    public function gamblingLoser(int $index): int
    {
        return 0;
    }


    /**
     * method gamblingDraw
     *
     *  Here we just return the bet since it was a draw.
     *
     * @return int $placedBet
     */
    public function gamblingDraw(int $index): int
    {
        $placedBet = $this->bets[$index];
        $this->balance += (int) $placedBet;
        return (int) $placedBet;
    }

    /**
     * method getBalance
     *
     *  Here we see our balance.
     *
     * @return int $balance
     */
    public function getBalance(): int
    {
        return $this->balance;
    }



    /**
     * method getBets
     *
     *  Here we saw all our bets we placed.
     *
     * @return array <int, int|string>
     */
    public function getBets(): array
    {
        return $this->bets;
    }



}
