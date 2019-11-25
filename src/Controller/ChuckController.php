<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @Route(name="chuck", path="/chuck")
 */
class ChuckController
{
    // https://api.chucknorris.io
    public function __invoke(HttpClientInterface $client, LoggerInterface $logger)
    {
        $response = $client->request('GET', 'https://api.chucknorris.io/jokes/random');

        $logger->info('got a joke', [
            'response' => $response
        ]);


        $joke = $response->toArray()['value'] ?? 'No joke!';

        return new Response(<<<HTML
<html>
    <head>
        <title>Chuck Norris - jokes</title>    
    </head>
    <body>
        <p>$joke</p>
    </body>
</html>
HTML
        );
    }
}
