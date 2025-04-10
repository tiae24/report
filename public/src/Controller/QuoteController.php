<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuoteController extends AbstractController
{

    #[Route("/api/")]
    public function api(): Response
    {
        $number = random_int(0, 100);

        $routes = [
            [
                'route' => '/api/quote',
                'metod' => 'GET',
                'beskrivning' => 'Slumpar fram en quote och när det hände'
            ]
            ];

        $data = [
            'route' => $routes
        ];

        return $this->render('api.html.twig', $data);

        return $response;
    }

    #[Route("/api/quote")]
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


    #[Route("/api/quotes")]
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

        $selectedQuote = $quotes[$number];

        return $this->render('quotes.html.twig', $data);

        return $response;
    }
}