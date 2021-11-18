<?php

declare(strict_types=1);

namespace src\Controller;

use src\Database\Connector;
use src\Http\Response;
use src\Repository\MoodRepository;
use src\Router\Route;
use src\Router\Router;

#[Route(path: '/deleteMood', name: 'deleteMood')]
class DeleteMood implements Controller
{
    public function __construct(private Router $router)
    {
    }

    public function display(): void
    {
        if (null !== $moodId = $_GET['id'] ?? null) {
            $moodRepository = new MoodRepository();
            $moodRepository->delete($moodId);
        }

        $response = new Response('',  307, ['location: '.$this->router->getPath('form')]);
        $response->display();
    }
}
