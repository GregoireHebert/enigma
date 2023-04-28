<?php

declare(strict_types=1);

namespace App\Customers\Infrastructure\Symfony\Controller;

use App\Artists\Domain\Entity\Song;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/play/{id}', methods: ['GET'], name: 'app_play')]
class PlayerController extends AbstractController
{
    public function __invoke(Song $song, HubInterface $hub)
    {
        $hub->publish(new Update(
            'play',
            $this->renderView('player/player.html.twig', ['song' => $song])
        ));

        return new Response();
    }
}
