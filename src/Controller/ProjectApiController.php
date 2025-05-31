<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Project\Cards;
use App\Project\DeckOfCards;
use App\Project\CardGraphic;
use App\Project\BlackJack;
use App\Project\Bank;

class ProjectApiController extends AbstractController
{
    #[Route("/project/api", name: "projectApi")]
    public function projectApi(): Response
    {

        $routes = [
            [
                'route' => '/project/api/bank',
                'metod' => 'GET',
                'beskrivning' => 'Shows a bank account with 3 players betting 100 each',
                'name' => 'bankApi'
            ],
            [
                'route' => '/project/api/bet',
                'metod' => 'POST',
                'beskrivning' => 'Choose the amount of players, how much money they have and what they should bet.',
                'name' => 'betApi'
            ],
            [
                'route' => '/project/api/game',
                'metod' => 'GET',
                'beskrivning' => 'Show a complete game of blackjack where the player draws 2 cards with 1 hand',
                'name' => 'gameApi'
            ],
            [
                'route' => '/project/api/deck',
                'metod' => 'GET',
                'beskrivning' => 'Show the total amount of cards in the BlackJack game, in this case its 4 decks',
                'name' => 'multipleDeckApi'
            ],
            [
                'route' => '/project/api/multi/game',
                'metod' => 'GET',
                'beskrivning' => 'Show a complete game of blackjack with 3 players',
                'name' => 'multiGameApi'
            ],
            [
                'route' => '/project/api/game/draw',
                'metod' => 'POST',
                'beskrivning' => 'Pick an amount of cards to draw, you will draw until you bust or get 21',
                'name' => 'drawCardsApi'
            ],
            ];



        $data = [
            'route' => $routes
        ];

        return $this->render('project/api.html.twig', $data);
    }


    #[Route("/project/api/deck", name: "multipleDeckApi")]
    public function multipleDeckApi(): Response
    {
        /** @var Bank $bank */
        $deck = new DeckOfCards(4);

        $data = [
            'deck' => $deck -> getCards(),
            'total' => $deck -> totalCards()
        ];


        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }




    #[Route("/project/api/bank", name: "bankApi")]
    public function bankApi(): Response
    {
        /** @var Bank $bank */
        $bank = new Bank(3, 1000);

        $bank->placeBet(0, 100);
        $bank->placeBet(1, 100);
        $bank->placeBet(2, 100);


        $data = [
            'balance' => $bank -> getBalance(),
            'bets' => $bank -> getBets()
        ];


        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }


    #[Route("/project/api/bet", name: "betApi", methods: ['POST'])]
    public function betApi(
        Request $request
    ): Response {
        /** @var Bank $bank */

        $form = $request->request->all();

        $bank = new Bank($form['players'], $form['money']);

        $bet = $form['bet'];


        for ($i = 0; $i < $form['players']; $i++) {
            $bank->placeBet($i, $bet);
        }


        $data = [
            'balance' => $bank -> getBalance(),
            'bets' => $bank -> getBets()
        ];


        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }



    #[Route("/project/api/game", name: "gameApi")]
    public function gameApi(): Response
    {
        /** @var BlackJack $deck */
        $deck = new BlackJack();
        $bank = new Bank(1, 1000);

        $bank->placeBet(0, 100);


        $try = $deck -> playerHand();

        $players = 3;

        $deck -> playerAction("draw1");
        $deck -> playerAction("draw1");


        $deck -> drawCard("dealer");
        $deck -> drawCard("dealer");

        $game = $deck -> gameOver();

        $winner = $bank->gamblingOutcome($game);


        $data = [
            'playerHand' => $deck -> playerHand(),
            'dealerHand' => $deck -> dealerHand(),
            'playerScore' => $deck -> getScore("player"),
            'dealerScore' => $deck -> getScore("dealer"),
            'game' => $game,
            'winner' => $winner,
            'balance' => $bank->getBalance(),
            'bets' => $bank->getBets(),
            'totalCards' => $deck->totalCards()
        ];


        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }



    #[Route("/project/api/multi/game", name: "multiGameApi")]
    public function multiGameApi(): Response
    {
        /** @var BlackJack $deck */
        $deck = new BlackJack();
        $bank = new Bank(3, 1000);

        $bank->placeBet(1, 100);
        $bank->placeBet(2, 100);
        $bank->placeBet(0, 100);


        $try = $deck -> playerHand();

        $players = 3;

        $deck -> playerAction("draw1");
        $deck -> playerAction("draw1");
        $deck -> playerAction("draw2");
        $deck -> playerAction("draw2");
        $deck -> playerAction("draw3");
        $deck -> playerAction("draw3");
        $deck -> playerAction("draw3");
        $deck -> playerAction("draw3");

        $deck -> drawCard("dealer");
        $deck -> drawCard("dealer");

        $game = $deck -> gameOver();

        $winner = $bank->gamblingOutcome($game);


        $data = [
            'playerHand' => $deck -> playerHand(),
            'dealerHand' => $deck -> dealerHand(),
            'playerScore' => $deck -> getScore("player"),
            'dealerScore' => $deck -> getScore("dealer"),
            'game' => $game,
            'winner' => $winner,
            'balance' => $bank->getBalance(),
            'bets' => $bank->getBets(),

        ];


        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }



    #[Route("/project/api/game/draw", name: "drawCardsApi")]
    public function drawCardsApi(
        Request $request
    ): Response {
        /** @var BlackJack $deck */
        $deck = new BlackJack();

        $form = $request->request->all();

        $draws = $form['draws'];

        for ($i = 0; $i < $draws; $i++) {
            $deck -> playerAction("draw1");
        }

        $deck -> drawCard("dealer");
        $deck -> drawCard("dealer");

        $game = $deck -> gameOver();




        $data = [
            'playerHand' => $deck -> playerHand(),
            'dealerHand' => $deck -> dealerHand(),
            'playerScore' => $deck -> getScore("player"),
            'dealerScore' => $deck -> getScore("dealer"),
            'game' => $game,

        ];


        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }


}
