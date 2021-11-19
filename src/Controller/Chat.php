<?php

declare(strict_types=1);

namespace src\Controller;

use src\Database\Connector;
use src\Entity\Message;
use src\Entity\Mood;
use src\Http\Response;
use src\Repository\MessageRepository;
use src\Repository\MoodRepository;
use src\Router\Route;
use src\Router\Router;
use src\Templating\Render;

#[Route(path: '/pasdaccord', name: 'chat')]
class Chat implements Controller
{
    public function __construct(private Router $router)
    {
    }

    public function display(): void
    {
        $messsageRepository = new MessageRepository();

        if (!empty($_POST['message'])) {
            $message = new Message();
            $message->author = $_POST['author'];
            $message->message = $_POST['message'];

            $messsageRepository->insert($message);
        }

        $results = $messsageRepository->fetchAll();

        $messages = '';
        foreach ($results as $message) {
            $messages .= (new Render())->render(
                'partials/message',
                [
                    'author' => $message->author,
                    'message' => $message->message,
                ]
            );
        }

        $content = (new Render())->render('layout', [
            'content' => (new Render())->render('chat', ['messages' => $messages])
        ]);

        $response = new Response($content);
        $response->display();
    }
}
