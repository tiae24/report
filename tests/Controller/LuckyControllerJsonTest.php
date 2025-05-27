<?php

// tests/Controller/ProfileControllerTest.php
namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LuckyControllerJsonTest extends WebTestCase
{
    public function testJsonNumber(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();

        // Request a specific page
        $crawler = $client->request('GET', '/api/lucky/number');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
    }

    public function testHi(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();

        // Request a specific page
        $crawler = $client->request('GET', '/lucky/hi');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
    }

    public function testLuckyNumber(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();

        // Request a specific page
        $crawler = $client->request('GET', '/lucky/number');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
    }


}