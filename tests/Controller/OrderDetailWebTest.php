<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;

class OrderDetailWebTest extends WebTestCase
{
    public function testInvalidSwitchStatus()
    {
        $client = static::createClient();
        $client->request('GET', '/orders/103/status/nimps');
        $this->assertInstanceOf(RedirectResponse::class, $client->getResponse());

        $crawler = $client->followRedirect();

        $this->assertContains(
            'status: Custom Cette valeur doit être l\'un des choix proposés.',
            $crawler->filter('div.alert')->text()
        );
    }

    public function testValidSwitchStatus(): void
    {
        $client = static::createClient();

        foreach (Order::STATUSES as $status) {
            $this->requestSwitchStatus($client, $status);
        }
    }

    private  function requestSwitchStatus(KernelBrowser $client, string $status): void
    {
        $client->request('GET', "/orders/103/status/$status");
        $this->assertInstanceOf(RedirectResponse::class, $client->getResponse());

        $crawler = $client->followRedirect();

        $this->assertContains(
            'Status mis à jour avec succès.',
            $crawler->filter('div.alert')->text()
        );
    }
}
