<?php

namespace App\Model;

interface Categories {
    public function getName() :string;
    public function setName(string $name): void;
    public function getId() :int;
    public function setId(int $id ) :void;
    public function getProduct() :string;
    public function setProduct(int $id ) :void;
}