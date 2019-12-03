<?php

namespace App\Entity;


use App\Model\clientInterface;
use App\Model\InterfaceCommande;

class Client implements clientInterface {
    private $Id;
    private $Nom;
    private $Adresse;
    private $Orders;


    function setId(int $id): int
    {
        $this->Id = $id;

    }

    function getId(): int
    {
        return $this->id;
    }

    function setNom(string $nom): string
    {
        $this->Nom = $nom;

    }

    function getNom(): string
    {
        return $this->Nom;
    }

    function setAdresse(string $adresse): string
    {
        $this->Adresse = $adresse;
    }

    function getAdresse(): string
    {
        return $this->Adresse;
    }

    function setOrders(array $orders)
    {
        $this->Orders = $orders;
    }

    function getOrders(): array
    {
        return $this->Orders;
    }

    function addOrder(InterfaceCommande $order): array
    {

        array_push($this->Orders,$order);
        return $this->Orders;

    }

}

