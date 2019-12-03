<?php

    class CommandesRepository{

        public function __construct(){

            $this->pdo = new \PDO('sqlite:'.__DIR__.'/../../var/database.sqlite');
            $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);

            $this->pdo->query(<<<SQL
CREATE TABLE IF NOT EXISTS commandes (
    id              INTEGER     PRIMARY KEY AUTOINCREMENT,
    custommer       INTEGER,
    selections      VARCHAR(255)
    
 
);
SQL
            );
        }



        public function insert(InterfaceCommande $commande){

            $commandesInsert = $this->prepare("INSERT INTO commandes VALUES null , :custommer, :selections");
            $commandesInsert->execute([
                ':custommer' => $commande->getClient()->getId(),
                ':selections' => implode (',',array_column($commande->getSelection(),'id'))

            ]);
        }

        public function update(InterfaceCommande $commande){

            $commandesUpdate = $this->prepare('UPDATE commandes SET :selections = :selections WHERE id = :id');
            $commandesUpdate->execute([
                ':id' => $commande->getId(),
                ':selections' =>  implode (',',array_column($commande->getSelection(),'id'))

            ]);
        }


        public function delete(int $id){

            $commandesDelete = $this->prepare('DELETE FROM commandes WHERE id = :id');
            $commandesDelete->execute([
                ':id' => $object->getId(),
            ]);
        }
        public function selectOne(){
            $commandesselectOne = $this->prepare('SELECT * FROM commandes WHERE id = :id');
            $commandesselectOne->execute([
                ':id' => $object->getId(),
            ]);

            return $commandesselectOne->fetchObject(Commandes::class);

        }
        public function selectAll(){
            $commandesselectAll = $this->prepare('SELECT * FROM commandes');
            $commandesselectAll->execute();

            return $commandesselectAll->fetchAll(\PDO::FETCH_CLASS, Commandes::class);
        }

    }