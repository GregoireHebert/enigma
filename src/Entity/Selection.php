<?php

declare(strict_types=1);

namespace App\Entity;

use App\Model\interfaceSelection;
use App\Model\Products;

class Selection implements interfaceSelection{

    private $produit;
    private $quantite;


    public function getProduit(): Products
    {
        return $this->produit;
    }

    public function setProduit(Products $InterfaceProduct)
    {
        $this->produit = $InterfaceProduct;
    }

    public function getQuantite(): int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite)
    {
        $this->quantite = $quantite;
    }

    public function ajoutQuantite(int $quantite)
    {
        $this->quantite += $quantite;
    }

    public function reduireQuantite(int $quantite)
    {
        $this->quantite -= $quantite;
    }
    public function __get($name)
    {
        if($name === 'id') {return $this->id;}
    }
    public function __isset($name)
    {
        return $name === 'id';
    }
}