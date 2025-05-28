<?php

// tests/Controller/ProfileControllerTest.php

namespace App\Tests\Controller;

use App\Cards\BlackJack;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GameControllerTest extends WebTestCase
{
    public function testGameSession(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();

        // Request a specific page
        $crawler = $client->request('GET', '/game/session');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
    }

    public function testStartGame(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();

        // Request a specific page
        $crawler = $client->request('GET', '/game');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
    }




    public function testGameDoc(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();

        // Request a specific page
        $crawler = $client->request('GET', '/game/doc');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
    }

}
