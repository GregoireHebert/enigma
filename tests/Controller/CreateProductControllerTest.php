<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateProductControllerTest extends WebTestCase
{
    public function testListProducts()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/products');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'Mon Formulaire de création de produits.');
    }
}
