<?php

declare(strict_types=1);

namespace App\Artists\Application\Messages;

use Symfony\Component\Form\FormInterface;

class CreateSongMessage
{
    public function __construct(FormInterface $form)
    {
    }
}
