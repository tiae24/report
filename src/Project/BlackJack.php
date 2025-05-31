<?php

namespace App\Project;

use App\Project\DeckOfCards;
use App\Project\BlackJackHand;
use App\Project\BlackJackWinner;
use App\Project\BlackJackAction;

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

    /** @var BlackJackAction */
    protected $action;

    /** @var int */
    protected $players = 0;

    /** @var string */
    protected $username = "";

    /** @var array <string, string> */
    protected $stand = [
                'stand0' => "Go",
                'stand1' => "Go",
                'stand2' => "Go",
            ];

    /**
     * @var array< string, array{}>
    */
    protected $playerHand = [
        'player' => []
    ];

    /** @var array<int, array{'suit': string, 'card': string, 'graphic': string}> */
    protected $dealerHand = [];


    /**
     * Constructor.
     *
     * Here we get out Deck, and Classes that we use to get scores and winners.
     * @return void
     */
    public function __construct()
    {
        $this->deck = new DeckOfCards(4);
        $this->hand = new BlackJackHand();
        $this->winner = new BlackJackWinner();
        $this->action = new BlackJackAction();
    }


    /**
     * method getStand
     *
     * Here we get to see if we have pressed the stand button.
     * @return array <string, string>
     */
    public function getStand(): array
    {
        return $this->stand;
    }


    /* method setUsername
     *
     * Here we set a Username
     */
    public function setUsername(string $name): void
    {
        $this->username = $name;
    }

    /**
     * method getUsername
     *
     * Here we get to see if we have pressed the stand button.
     * @return string we return our username
     */
    public function getUsername(string $name): string
    {
        return $this->username;
    }


    /**
     * method setPlayers
     *
     * Here we decide how many players are in the game
     * @return void */
    public function setPlayers(int $players): void
    {
        $this->players = $players;
    }


    /**
     * method getPlayers
     *
     * Here we return how many players are in the game.
     * @return int $players
     * */
    public function getPlayers(): int
    {
        return $this->players;
    }


    /**
     * method setPlayerHands
     *
     * Here we set a players Hand, we can custom make hands for testing with this.
     * @return void */
    public function setPlayerHands(): void
    {
        $players = $this->players;

        for ($i = 1; $i <= $players; $i++) {
            $this->playerHand['player'][$i] = [];
        }
    }


    /**
     * method getScore
     *
     * Here is where we get score for the players and dealers hand
     * With an ace and the face cards we give them a numerical value instead.
     * @param string $player
     * @return array< string, list<int>> $score
     */
    public function getScore(string $player): array
    {
        if ($player != "dealer") {
            $score = [];
            foreach ($this->playerHand['player'] as $new) {
                $score['player'][] = $this->hand->getScore($new);
            }
        } else {
            $score['dealer'][] = $this->hand->getScore($this->dealerHand);
        }


        return $score;
    }

    /**
     * method drawCard
     *
     * Here is where we draw a card to add to the hand of either the player or dealer.
     * our parameter is where we write if we are the player or dealer so we know where to add the cards
     * If we are the dealer we loop until our hand is worth atleast 17.
     * @param string $player
     * @param int $amount
     * @return array<int|string,array<'card'|'graphic'|'suit'|int, array{array{suit: string, card: string, graphic: string}}|string>> $hand
     */
    public function drawCard(string $player, int $amount = 0): array
    {
        $hand = [];

        if ($player != 'dealer') {
            $drawn = $this->deck -> drawCard(1);

            //Here we check so we cant draw cards when we have 21 or busted
            $score = $this->getScore("player");

            if ($score && isset($score["player"][$amount - 1])) {
                if ($score["player"][$amount - 1] >= 21) {
                    return $this->playerHand['player'];
                }
            }

            $this->playerHand['player'][$amount][] = $drawn[0];

            $hand = $this->playerHand;


        } elseif ($player == 'dealer') {
            if (count($this->dealerHand) === 0) {
                $drawn2 = $this->deck -> drawCard(1);

                $this->dealerHand[] = $drawn2[0];
            } else {
                $score = $this->getScore("dealer");
                while ($score["dealer"][0] <= 17) {
                    $drawn2 = $this->deck -> drawCard(1);

                    $this->dealerHand[] = $drawn2[0];
                    $score = $this->getScore("dealer");
                }
            }


            $hand =  $this->dealerHand;

        }

        return $hand;
    }


    /**
     * method playerHand
     *
     * Here is where we return our player hand.
     * @return array<string, array{}> */
    public function playerHand(): array
    {
        return $this->playerHand;
    }

    /**
     * method dealerHand
     *
     * Here is where we return our dealer hand.
     * @return array<int, array{'card': string, 'graphic': string}> */
    public function dealerHand(): array
    {
        return $this->dealerHand;
    }

    /**
     * method gameOver
     *
     * Here is where we check the state of our game and see which player won.
     * @return array <string>*/
    public function gameOver(): array
    {
        $playerScore = $this->getScore("player");
        $dealerScore = $this->getScore("dealer");

        $winner = [];

        if ($playerScore) {
            foreach ($playerScore["player"] as $score) {
                $winner[] = $this->winner->gameOver($dealerScore["dealer"][0], $score);
            }
        }


        return $winner;

    }





    /**
     * method setPlayerHand
     *
     * I used this for the test and its where we can decide how our players hand should look.
     * @param array <int, array{'card': string, 'graphic': string}> $hand
     * @param int $player
     * @return array <string, array{}>  */
    public function setPlayerHand(array $hand, int $player): array
    {
        $this->playerHand['player'][$player] = $hand;

        return $this->playerHand;
    }


    /**
     * method setDealerHand
     *
     * I used this for the test and its where we can decide how our dealers hand should look.
     * @param array<int, array{'suit': string, 'card': string, 'graphic': string}> $hand
     * @return array<int, array{'card': string, 'graphic': string}> */
    public function setDealerHand(array $hand): array
    {
        $this->dealerHand = $hand;
        return $this->dealerHand;
    }


    /**
     * method playerAction
     *
     * I used this for the test and its where we can decide how our dealers hand should look.
     * @param string $index
     * @return void*/
    public function playerAction(string $index): void
    {
        $stand = $this->stand;

        if ($index[0] == 'd') {
            $player = $this->findPlayer($index);
            $this->drawCard("player", (int) $player);

        } elseif ($index[0] == 's') {
            $newStand = $this->action->action($stand, $index);
            $this->stand = $newStand;
        }

        $this->stopPlayer();
    }


    /**
     * method findPlayer
     * 
     * Find the "id" for the last player, for example 3
     * if we draw with player3
     * @param string $index
     * @return string $last
     */
    public function findPlayer(string $index): string
    {
        $last = substr($index, -1);
        return $last;
    }

    /**
     * method stopPlayer
     * 
     * Stop a plays ability to draw if you bust
     * @return void
     */
    public function stopPlayer(): void
    {
        $stand = $this->stand;
        $game = $this->gameOver();
        $this->stand = $this->action->stopHand($game, $stand);

    }


    /**
     * method dealersTurn
     * 
     * See if it is the dealers turn to play, when all your hands are "done"
     * @return string $dealersTurn
     */
    public function dealersTurn(): string
    {
        $stand = $this->stand;
        $game = $this->gameOver();
        $dealersTurn = $this->action->dealersTurn($game, $stand);

        if ($dealersTurn == 'draw') {
            $this->drawCard("dealer");
            $dealersTurn = "Start";
        }

        return $dealersTurn;
    }

    /**
     * method totalCards
     * 
     * Get the total amount of cards in the deck
     * @return string $total
     */
    public function totalCards(): string
    {
        $total = $this->deck->totalCards();

        return $total;
    }

}
