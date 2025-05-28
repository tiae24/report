<?php

// tests/Controller/ProfileControllerTest.php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CardsControllerTest extends WebTestCase
{
    public function testSessionStart(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();

        // Request a specific page
        $crawler = $client->request('GET', '/session');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
    }

    public function testSessionDelete(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();

        // Request a specific page
        $crawler = $client->request('GET', '/session/delete');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
    }


    public function testCard(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();

        // Request a specific page
        $crawler = $client->request('GET', '/card');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
    }



}
