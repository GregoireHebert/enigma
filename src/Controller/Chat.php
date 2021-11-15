<?php

declare(strict_types=1);

namespace App\Controller;

use App\Routing\Routing;
use App\Security\Security;
use App\Database\Connector;
use App\Entity\Message;
use \PDO;

class Chat implements Controller
{
    public function display(?Routing $routing = null)
    {
        Security::denyUnlessLoggedIn($routing);

        try {
            $pdo = Connector::getPdo();

            $PDOstatement = $pdo->query(<<<SQL
select pseudo, avatar, message, date from messages
JOIN inscrits on inscrits.id = messages.sender;
SQL);
            $messages = $PDOstatement->fetchAll(PDO::FETCH_CLASS, Message::class);

            if (!empty($_POST['message'])) {
                $preparation = $pdo->prepare(<<<SQL
insert into messages values (null, :id, :message, :date);
SQL);
                $date = time();

                $preparation->bindParam('id', $_SESSION['user']->id, PDO::PARAM_INT);
                $preparation->bindParam('message', $_POST['message']);
                $preparation->bindParam('date', $date, PDO::PARAM_INT);
                $preparation->execute();

                $messages[] =  (new Message)->hydrate(
                    $_SESSION['user']->pseudo,
                    $_POST['message'],
                    $_SESSION['user']->avatar,
                    (int) $pdo->lastInsertId(),
                    $date,
                );
            }
        } catch (\PDOException $e) {
            // envoie un log, mail, sms
            echo $e->getMessage();
            $error = 'Impossible d\'envoyer le message, veuillez réessayer plus tard';
            $messages = [];
        }

        require_once(__DIR__.'/../../templates/chat.phtml');
    }
}

