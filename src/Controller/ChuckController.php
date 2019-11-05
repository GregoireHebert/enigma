<?php

declare(strict_types=1);

namespace App\Controller;

use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChuckController
{
    public function __invoke(Client $client, LoggerInterface $logger)
    {
        $response = $client->get('/jokes/random');
        $data = json_decode($response->getBody()->getContents());

        $logger->info('Got a Chuck Norris joke', [
            'data' => $data
        ]);

        throw new \Exception('zeoefh');

        $joke = $data->value;

        return new Response(<<<HTML
<html>
    <head></head>
    <body>$joke</body>
</html>
HTML
        );
    }
}
