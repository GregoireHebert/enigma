<?php

declare(strict_types=1);

namespace App\Controller;

use App\Helper\LogTrait;

class HttpError implements Controller
{
    use LogTrait;

    public function display($error = 400, \Exception|\Error $originError = null)
    {
        $this->emergency('Une erreur est survenue : ' . $originError?->getMessage());

        if (file_exists(__DIR__."/../../templates/$error.phtml")) {
            require_once(__DIR__."/../../templates/$error.phtml");
            return;
        }

        require_once(__DIR__."/../../templates/400.phtml");
    }
}
