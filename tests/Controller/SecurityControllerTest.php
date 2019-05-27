<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLogin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Please sign in', $crawler->filter('body')->html());

        // email not exists
        $form = $crawler->selectButton('Sign in')->form();
        $client->submit($form, [
            'email' => 'no@fake.com',
            'password' => 'no'
        ]);
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Invalid credentials.', $crawler->filter('.alert')->html());
        $this->assertContains('Please sign in', $crawler->filter('body')->html());

        // wrong password
        $client->submit($form, [
            'email' => 'user1@fake.com',
            'password' => 'pass'
        ]);
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Invalid credentials.', $crawler->filter('.alert')->html());
        $this->assertContains('Please sign in', $crawler->filter('body')->html());

        // ok
        $client->submit($form, [
            'email' => 'user1@fake.com',
            'password' => 'password'
        ]);
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Conundrum Entry Point', $crawler->filter('.wrapper')->html());
    }
}
