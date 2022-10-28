<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomePageControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        
        // On vérifie si le solde total (en utilisant les valeurs des fixtures) et les trends affiché sur la page est correct
        $this->assertSelectorTextContains('.balance a', '206,26 €');
        $this->assertSelectorExists('#btc-trend .fa-arrow-trend-down');
        $this->assertSelectorExists('#eth-trend .fa-arrow-trend-up');
        $this->assertSelectorExists('#xrp-trend .fa-arrow-trend-down');
    }
}