<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CoinControllerTest extends WebTestCase
{
    // Teste l'ajout d'un montant et vérifie si le montant est correct sur la page d'accueil
    public function testAdd()
    {
        $client = static::createClient();
        $client->followRedirects();
        $client->request('GET', '/add');

        $this->assertResponseIsSuccessful();
        
        $crawler = $client->submitForm('Valider', [
            'coin_form[coinname]' => 'btc',
            'coin_form[quantity]'=> '0,2',
        ]);

        $this->assertSelectorTextContains('.balance a', '4 099,06 €');
    }

    // Teste la suppression d'un montant et vérifie si le montant est correct sur la page d'accueil
    public function testDelete()
    {
        $client = static::createClient();
        $client->followRedirects();
        $client->request('GET', '/delete');

        $this->assertResponseIsSuccessful();
        
        $crawler = $client->submitForm('Valider', [
            'coin_form[coinname]' => 'btc',
            'coin_form[quantity]'=> '0,002',
        ]);

        $this->assertSelectorTextContains('.balance a', '167,33 €');
    }

    // Teste si le solde ne peut pas être en négatif
    public function testDeleteNoNegative()
    {
        $client = static::createClient();
        $client->followRedirects();
        $client->request('GET', '/delete');

        $this->assertResponseIsSuccessful();
        
        $crawler = $client->submitForm('Valider', [
            'coin_form[coinname]' => 'btc',
            'coin_form[quantity]'=> '1000',
        ]);

        $client->request('GET', '/delete');
        $crawler = $client->submitForm('Valider', [
            'coin_form[coinname]' => 'eth',
            'coin_form[quantity]'=> '1000',
        ]);

        $client->request('GET', '/delete');
        $crawler = $client->submitForm('Valider', [
            'coin_form[coinname]' => 'xrp',
            'coin_form[quantity]'=> '1000',
        ]);

        $this->assertSelectorTextContains('.balance a', '0,00 €');
    }
}