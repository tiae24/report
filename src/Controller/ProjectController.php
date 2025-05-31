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

class ProjectController extends AbstractController
{
    #[Route("/proj", name: "project")]
    public function project(): Response
    {

        return $this->render('project/main.html.twig');

    }


    #[Route("/proj/about", name: "projectAbout")]
    public function projectAbout(): Response
    {

        return $this->render('project/about.html.twig');

    }

    #[Route("/proj/session", name: "projSession")]
    public function projSession(
    ): Response {
        /** @var BlackJack $deck */
        $deck = new BlackJack();
        $bank = new Bank(3, 1000);

        $bank->placeBet(1, 100);
        $bank->placeBet(2, 100);
        $bank->placeBet(0, 100);

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





    #[Route("/proj/bank", name: "projBank")]
    public function projBank(
    ): Response {
        /** @var Bank $bank */
        $bank = new Bank(2, 1000);

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






    #[Route('/proj/game', name: "projStart")]
    public function projStart(
        SessionInterface $session
    ): Response {

        /** @var BlackJack */
        $deck = new BlackJack();

        $session->set('game', $deck);

        $session->set('betsPlaced', 'NotPlaced');

        $routes = [
            [
                'route' => '/game/doc',
                'metod' => 'GET',
                'beskrivning' => 'Gör våran kortlek för sessionen, måste göras innan vi börjar',
                'name' => 'gameDocumentation'
            ]
            ];

        $data = [
            'playerHand' => $deck -> playerHand(),
            'dealerHand' => $deck -> dealerHand(),
            'playerScore' => $deck -> getScore("player"),
            'dealerScore' => $deck -> getScore("dealer"),
            'route' => $routes
        ];

        return $this->render('project/start.html.twig', $data);
    }


    #[Route('/proj/play', name: "projGame")]
    public function projGame(
        Request $request,
        SessionInterface $session
    ): Response {
        /** @var BlackJack $deck */
        $deck = $session->get("game");
        $players = $session->get("players");
        $betsPlaced = $session->get("betsPlaced");

        /** @var Bank $bank */
        $bank = $session->get("bank");


        $action = $request->request->get('action');

        if ($action) {
            $deck -> playerAction($action);
        }

        $stand = $deck -> getStand();

        $dealerTurn = $deck->dealersTurn();

        $game = $deck -> gameOver();

        print_r($bank->gamblingOutcome($game));


        $data = [
            'playerHand' => $deck -> playerHand(),
            'dealerHand' => $deck -> dealerHand(),
            'playerScore' => $deck -> getScore("player"),
            'dealerScore' => $deck -> getScore("dealer"),
            'game' => $game,
            'players' => $players,
            'stand' => $stand,
            'dealerTurn' => $dealerTurn,
            'betsPlaced' => $betsPlaced,
            'balance' => $bank->getBalance(),
            'winners' => $bank->gamblingOutcome($game),
            'bets' => $bank->getBets(),
        ];

        return $this->render('project/game.html.twig', $data);

    }


    #[Route('/proj/player', name: 'projPlayers', methods: ['POST'])]
    public function projPlayers(
        Request $request,
        SessionInterface $session
    ): Response {

        /** @var BlackJack $deck */
        $deck = $session->get("game");

        $form = $request->request->all();

        $players = $form['players'];
        $username = $form['username'];

        /** @var Bank $bank */
        $bank = new Bank($players, (int) 100000000);

        $session->set('bank', $bank);

        $stand = [
            'stand0' => "Go",
            'stand1' => "Go",
            'stand2' => "Go",
        ];

        $session->set('stand', $stand);
        $session->set('players', $players);
        $session->set('username', $username);

        $deck -> drawCard("dealer");
        $deck->setPlayers($players);
        $deck->setPlayerHands();

        return $this->redirectToRoute('projGame');
    }



    #[Route('/proj/bet', name: 'projBet', methods: ['POST'])]
    public function projBet(
        SessionInterface $session
    ): Response {

        /** @var Bank $bank */
        $bank = $session->get("bank");
        $username = $session->get("username");
        $players = $session->get("players");

        $session->set('betsPlaced', 'Placed');

        for ($i = 0; $i < $players; $i++) {
            $bank->placeBet($i, $_POST['bet'. $i]);
        }

        return $this->redirectToRoute('projGame');
    }
}
