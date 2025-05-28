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

class CardsController extends AbstractController
{
    #[Route("session", name: "sessionStart")]
    public function sessionStart(
        SessionInterface $session
    ): Response {
        /** @var DeckOfCards $deck */
        $deck = new DeckOfCards();

        $session->set('deck', $deck);

        /** @var DeckOfCards $deck */
        $deck = $session->get("deck");

        $drawn = $deck -> drawCard(1);

        $data = [
            'decks' => $deck -> getCards(),
            'card' => $deck -> getString(),
            'graphic' => $deck -> getCard(),
            'suit' => $deck -> getSuit(),
            'total' => $deck -> totalCards(),
            'nyrandom' => $drawn,
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/session/delete", name: "sessionDelete")]
    public function sessionDelete(
        SessionInterface $session
    ): Response {
        $session->clear();

        $this->addFlash(
            'warning',
            'You cleared your session, go back to session to recreate it'
        );
        // $this->addFlash() is equivalent to $request->getSession()->getFlashBag()->add()
        // $this->cards[] = new Card("joker", "black");

        return $this->render('cards/clear.html.twig');
    }

    #[Route("/card", name: "card")]
    public function card(
    ): Response {
        $routes = [
            [
                'route' => '/session',
                'metod' => 'GET',
                'beskrivning' => 'Gör våran kortlek för sessionen, måste göras innan vi börjar',
                'name' => 'sessionStart'
            ],
            [
                'route' => '/session/delete',
                'metod' => 'GET',
                'beskrivning' => 'Rensar våran session',
                'name' => 'sessionDelete'
            ],
            [
                'route' => '/card/deck',
                'metod' => 'GET',
                'beskrivning' => 'Visar en kortlek',
                'name' => 'deck'
            ],
            [
                'route' => '/card/deck/shuffle',
                'metod' => 'POST',
                'beskrivning' => 'Blandar kortleken',
                'name' => 'shuffle'
            ],
            [
                'route' => '/card/deck/draw',
                'metod' => 'POST',
                'beskrivning' => 'Drar ett kort från kortleken',
                'name' => 'draw'
            ],
            [
                'route' => '/card/deck/draw/:number',
                'metod' => 'POST',
                'beskrivning' => 'Drar 5 kort från kortlecken',
                'name' => 'drawNumber'
            ]
            ];

        $data = [
            'route' => $routes
        ];

        return $this->render('cards/load.html.twig', $data);
    }

    #[Route("/card/deck", name: "deck")]
    public function deck(
        SessionInterface $session
    ): Response {

        /** @var DeckOfCards $deck */
        $deck = $session->get("deck");

        $data = [
            'suit' => $deck -> getSuit(),
            'cards' => $deck -> getCard()
        ];

        return $this->render('cards/cards.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "shuffle")]
    public function shuffle(
        SessionInterface $session
    ): Response {

        /** @var DeckOfCards $deck */
        $deck = $session->get("deck");

        $shuffled = clone $deck;

        $shuffled -> shuffle();

        $data = [
            'suit' => $shuffled -> getSuit(),
            'cards' => $shuffled -> getCard()
        ];


        return $this->render('cards/cards.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "draw")]
    public function draw(
        SessionInterface $session
    ): Response {

        /** @var DeckOfCards $deck */
        $deck = $session->get("deck");

        $drawn = $deck -> drawCard(1);

        $data = [
            'cards' => $drawn,
            'total' => $deck -> totalCards()
        ];

        return $this->render('cards/draw.html.twig', $data, );
    }

    #[Route("/card/deck/draw/{number}", name: "drawNumber")]
    public function drawNumber(
        string $number,
        SessionInterface $session
    ): Response {

        /** @var DeckOfCards $deck */
        $deck = $session->get("deck");

        $drawn = $deck -> drawCard((int) $number);

        $data = [
            'suit' => $drawn[0],
            'cards' => $drawn,
            'total' => $deck -> totalCards()
        ];

        return $this->render('cards/draw.html.twig', $data, );
    }
}
