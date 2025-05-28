<?php

// tests/Controller/ProfileControllerTest.php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MetricsControllerJsonTest extends WebTestCase
{
    public function testMetrics(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();

        // Request a specific page
        $crawler = $client->request('GET', '/metrics');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
    }



}
