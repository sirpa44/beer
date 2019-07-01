<?php declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
{

    public function testGetTransactionInstruction()
    {
        $in = json_encode([
            ['name' => '1', 'beer' => '20', 'capacity' => '30'],
            ['name' => '2', 'beer' => '10', 'capacity' => '50'],
            ['name' => '3', 'beer' => '20', 'capacity' => '20']
        ]);
        $out = json_encode([
            ["source" => "1","destination" => "2","amount" => 5],
            ["source" => "3","destination" => "2","amount" => 10]
        ]);
        $client = static::createClient();
        $client->request('POST', '/beer',[],[],[],$in);
        $this->assertEquals($out, $client->getResponse()->getContent());
    }
}