<?php

// tests/Controller/ProfileControllerTest.php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QuoteControllerTest extends WebTestCase
{
    public function testJsonShowQuote(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();

        // Request a specific page
        $crawler = $client->request('GET', '/api/quote');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
    }

    public function testShowQuote(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();

        // Request a specific page
        $crawler = $client->request('GET', '/api/quotes');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
    }

    public function testApi(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();

        // Request a specific page
        $crawler = $client->request('GET', '/api/');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
    }

}
