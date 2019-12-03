<?php
interface InterfaceCommande{

    public function getSelections():array;
    public function setSelections(array $selections);

    public function getClient():Client; 
    public function setClient(Client $client);
    
    public function AddSelection(InterfaceSelection $selection);
    public function RemoveSelection(InterfaceSelection $selection);
}
?>