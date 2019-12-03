<?php

declare(strict_types=1);

namespace App\Entity;

use App\Model\ClientInterface;
use App\Model\InterfaceCommande;
use App\Model\InterfaceSelection;

class Commandes implements InterfaceCommande {

    private $client;
    private $selections = array();

    public function getSelections(): array
    {
        return $this->selections;
    }

    public function setSelections(array $selections)
    {
        $this->selections = $selections;
    }

    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function addSelection(InterfaceSelection $selection)
    {
        array_push($this->selections, $selection);
    }

    public function updateSelection(InterfaceSelection $selection)
    {
        for($i = 0; count($this->selections); $i++){
            if($this->selections[$i]->getProduit() === $selection->getProduit()){
                $this->selections[$i] = $selection;
                break;
            }
        }
    }

    public function removeSelection(InterfaceSelection $selection)
    {
        unset($this->selections[array_search($selection, $this->selections)]);
    }
public function __get($name){
if ($name === 'id'){
return$this->id;
}

}
public function __isset($name){
return$name === 'id';

    }





}