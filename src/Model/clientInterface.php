<?php

declare(strict_types=1);

namespace App\Model;

interface clientInterface {

    function setId(): int;
    function getId(): int;
    function setNom(): string;
    function getNom(): string;
    function setAdresse(): string;
    function getAdresse(): string;
    function setPoints(): int;
    function getPoints(): int;
}