<?php
interface InterfaceCommande{

    public function getSelections():array;
    public function setSelections(array $selections);

    public function getClient():ClientInterface; 
    public function setClient(ClientInterface $client);
    
    public function addSelection(InterfaceSelection $selection);
    public function updateSelection(InterfaceSelction $selection);
    public function removeSelection(InterfaceSelection $selection);
}
?>