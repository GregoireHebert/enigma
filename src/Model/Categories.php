<?php

namespace App\Model;

interface Categories {
    public function getName() :string;
    public function setName(string $name): void;
    public function getId() :int;
    public function setId(int $id ) :void;
}