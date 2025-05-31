<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Cards\Cards;
use App\Cards\DeckOfCards;
use App\Cards\CardGraphic;
use App\Cards\BlackJack;

class GameController extends AbstractController
{
    #[Route("/game/session", name: "gameSession")]
    public function gameSession(
    ): Response {
        /** @var BlackJack $deck */
        $deck = new BlackJack();


        $game = $deck -> gameOver();
        $data = [
            'playerHand' => $deck -> playerHand(),
            'dealerHand' => $deck -> dealerHand(),
            'playerScore' => $deck -> getScore($deck -> playerHand()),
            'dealerScore' => $deck -> getScore($deck -> dealerHand()),
            'game' => $game
        ];


        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }


    #[Route('/game', name: "startGame")]
    public function startGame(
        SessionInterface $session
    ): Response {

        /** @var BlackJack */
        $deck = new BlackJack();

        $session->set('game', $deck);

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
            'playerScore' => $deck -> getScore($deck -> playerHand()),
            'dealerScore' => $deck -> getScore($deck -> dealerHand()),
            'route' => $routes
        ];

        return $this->render('game/start.html.twig', $data);
    }

    #[Route('/game/play', name: "playGame")]
    public function playGame(
        Request $request,
        SessionInterface $session
    ): Response {
        /** @var BlackJack $deck */
        $deck = $session->get("game");


        $action = $request->request->get('action');

        if ($action === 'draw') {
            $deck -> drawCard("player");
        } elseif ($action === 'stand') {
            $deck -> drawCard("dealer");
        }

        $game = $deck -> gameOver();

        $data = [
            'playerHand' => $deck -> playerHand(),
            'dealerHand' => $deck -> dealerHand(),
            'playerScore' => $deck -> getScore($deck -> playerHand()),
            'dealerScore' => $deck -> getScore($deck -> dealerHand()),
            'game' => $game
        ];

        return $this->render('game/game.html.twig', $data);
    }

    #[Route('/game/doc', name: "gameDocumentation")]
    public function gameDoc(
    ): Response {

        return $this->render('game/doc.html.twig');
    }

}
