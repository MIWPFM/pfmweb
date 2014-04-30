<?php

namespace MIW\IntranetBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MyProfileControllerTest extends WebTestCase
{
    public function testViewmyinfo()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/mis-datos');
    }

}
