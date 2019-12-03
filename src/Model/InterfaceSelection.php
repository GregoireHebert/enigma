<?php
interface interfaceSelection{
    public function getProduit():Products;
    public function setProduit(Products $InterfaceProduct);

    public function getQuantite():int;
    public function setQuantite(int $quantite);
    public function AjoutQuantite(int $quantite);
    public function ReduireQuantite(int $quantite);

}
?>