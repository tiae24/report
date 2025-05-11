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

class ApiController extends AbstractController
{
    #[Route("/api/deck", name: "api_deck", methods: ['GET'])]
    public function apiDeck(): Response
    {
        /** @var DeckOfCards $deck */
        $deck = new DeckOfCards();

        $data = [
            'decks' => $deck -> getString(),
            'total' => $deck -> totalCards()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/shuffle", name: "api_shuffle", methods: ['POST'])]
    public function apiShuffle(
        SessionInterface $session
    ): Response {
        /** @var DeckOfCards $deck */
        $deck = new DeckOfCards();

        $session->set('deck', $deck);

        /** @var DeckOfCards $deck */
        $deck = $session->get("deck");

        $deck -> shuffle();

        $data = [
            'decks' => $deck -> getString(),
            'total' => $deck -> totalCards()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/draw", name: "api_draw", methods: ['POST'])]
    public function apiDrawCard(
        SessionInterface $session
    ): Response {
        /** @var DeckOfCards $deck */
        $deck = $session->get("deck");

        $drawn = $deck -> drawCard(1);

        $data = [
            'cards' => $drawn,
            'total' => $deck -> totalCards()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/card/deck/draw/{number}", name: "api_draw_cards", methods: ['POST'])]
    public function apiDrawCards(
        string $number,
        SessionInterface $session
    ): Response {

        /** @var DeckOfCards $deck */
        $deck = $session->get("deck");

        $drawn = $deck -> drawCard((int) $number);


        $data = [
            'suit' => $drawn[0]
        ];

        $data = [
            'cards' => $drawn,
            'total' => $deck -> totalCards()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/game", name: "api_game", methods: ['GET'])]
    public function apiGame(SessionInterface $session): Response
    {
        /** @var BlackJack $deck */
        $deck = $session->get("game");

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

}
