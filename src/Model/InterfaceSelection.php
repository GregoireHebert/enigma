<?php
interface interfaceSelection{
    public function getProduit():Products;
    public function setProduit(Products $InterfaceProduct);

    public function getQuantite():int;
    public function setQuantite(int $quantite);
    public function ajoutQuantite(int $quantite);
    public function reduireQuantite(int $quantite);

}
?>