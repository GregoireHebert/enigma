<?php

declare(strict_types=1);

namespace App\Model;

interface clientInterface {

    function setId(int $id): int;
    function getId(): int;
    function setNom(string $nom): string;
    function getNom(): string;
    function setAdresse(string $adresse): string;
    function getAdresse(): string;

    //Les points de fidélité ne sont pas définis au niveau des produits.
    /*function setPointFidelite(int $point): int;
    function getPointFidelite(): int;
    function addPointFidelite(): int;
    function removePointFidelite(): int;*/

    function setOrders(array $orders);
    function getOrder(): Array;
    function addOrder(InterfaceCommande $order): Array;
}