<?php

declare(strict_types=1);

namespace App\Entity;


use App\Model\clientInterface;
use App\Model\InterfaceCommande;

class Client implements clientInterface {
    private $id;
    private $nom;
    private $adresse;
    private $orders;


    function setId(int $id): int
    {
        $this->id = $id;

    }

    function getId(): int
    {
        return $this->id;
    }

    function setNom(string $nom): string
    {
        $this->nom = $nom;

    }

    function getNom(): string
    {
        return $this->nom;
    }

    function setAdresse(string $adresse): string
    {
        $this->adresse = $adresse;
    }

    function getAdresse(): string
    {
        return $this->adresse;
    }

    function setOrders(array $orders)
    {
        $this->orders = $orders;
    }

    function getOrders(): array
    {
        return $this->orders;
    }

    function addOrder(InterfaceCommande $order): array
    {

        array_push($this->orders,$order);
        return $this->orders;

    }

}

