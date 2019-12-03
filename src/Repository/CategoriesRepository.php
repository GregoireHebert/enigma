<?php
declare(strict_types=1);

namespace APP\Repository;

use App\Model\Categories;

class CategoriesRepository
{
     private $pdo;
     public function __construct()
     {
         $this->pdo= new \PDO('sqlite:'.__DIR__.'/../Var/database.sqlite');
         $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
         $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

         $this->pdo->query(<<<SQL
CREATE TABLE IF NOT EXISTS CATEGORIES (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
   `name` VARCHAR
);
SQL
        );
    }

    public  function insert(Categories $categories){
            $preparation = $this->pdo->prepare('INSERT INTO categories VALUES (null, :name');
            $preparation->execute([
                ':name'=>$categories->getName()
            ]);
        }
    public function update(Categories $categories){
            $preparation = $this->pdo->prepare('UPDATE categories SET name = :name');
            $preparation->execute([
            ':name'=>$categories->getName()
        ]);
    }

    public function delete (Categories $categories){
            $preparation = $this->pdo->prepare('DELETE FROM categories WHERE id = :id');
            $preparation->execute([
            ':id'=>$categories->getId()
        ]);
     }


    public function getAll (Categories $categories){
        $preparation = $this->pdo->prepare('SELECT * FROM categories');
        $preparation->execute([
            'id'=>$categories->getId(),
            ':name'=>$categories->getName()
        ]);
    }

    public function getOne (Categories $categories){
        $preparation = $this->pdo->prepare('SELECT * FROM categories where id=:id');
        $preparation->execute([
            'id'=>$categories->getId()
        ]);
    }

}

