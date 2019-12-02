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
    function setPoint(int $point): int;
    function getPoint(): int;
    function addPoint(): int;
    function setOrder(Categories $interfaceCommande);
    function getOrder(): Array;
    function addOrder(): Array;
}