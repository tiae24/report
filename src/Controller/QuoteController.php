<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuoteController extends AbstractController
{
    #[Route("/api/", name: "api")]
    public function api(): Response
    {

        $routes = [
            [
                'route' => '/api/quote',
                'metod' => 'GET',
                'beskrivning' => 'Slumpar fram en quote och när det hände',
                'name' => 'quote'
            ],
            [
                'route' => '/api/deck',
                'metod' => 'GET',
                'beskrivning' => 'Visar en kortlek',
                'name' => 'api_deck'
            ],
            [
                'route' => '/api/deck/shuffle',
                'metod' => 'POST',
                'beskrivning' => 'Blandar kortleken',
                'name' => 'api_shuffle'
            ],
            [
                'route' => '/api/deck/draw',
                'metod' => 'POST',
                'beskrivning' => 'Drar ett kort från kortleken',
                'name' => 'api_draw'
            ],
            [
                'route' => '/api/deck/draw/:number',
                'metod' => 'POST',
                'beskrivning' => 'Drar 5 kort från kortlecken',
                'name' => 'api_draw_cards'
            ],
            [
                'route' => '/api/game',
                'metod' => 'GET',
                'beskrivning' => 'Kolla på hur kortspelets omgång ser ut',
                'name' => 'api_game'
            ],
            [
                'route' => '/api/library/books',
                'metod' => 'GET',
                'beskrivning' => 'Visa alla böcker',
                'name' => 'api_book_show_all'
            ],
            [
                'route' => '/api/library/book/:isbn',
                'metod' => 'GET',
                'beskrivning' => 'Visa en bok',
                'name' => 'api_book_by_isbn'
            ]
            ];

        $data = [
            'route' => $routes
        ];

        return $this->render('api.html.twig', $data);
    }

    #[Route("/api/quote", name: "quote")]
    public function apiQuote(): Response
    {
        $number = random_int(0, 2);

        $date = date('c');

        $quotes = [
            "I think, therefore I am. ",
            "I may disagree with what you say, but I will defend to death your right to say it.",
            "Small things make perfection, but perfection is no small thing."
        ];

        $data = [
            'number' => $number,
            'quote' => $quotes[$number],
            'date' => $date
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }


    #[Route("/api/quotes", name: "quotes")]
    public function apiShowQuote(): Response
    {
        $number = random_int(0, 2);

        $date = date('c');

        $quotes = [
            "I think, therefore I am. ",
            "I may disagree with what you say, but I will defend to death your right to say it.",
            "Small things make perfection, but perfection is no small thing."
        ];

        $data = [
            'number' => $number,
            'quote' => $quotes[$number],
            'date' => $date
        ];

        return $this->render('quotes.html.twig', $data);
    }
}
