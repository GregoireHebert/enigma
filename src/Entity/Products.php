<?php

    namespace App\Entity;

    use App\Model;

    class Products
    {
        private $price;
        private $id;
        private $name;
        private $categories;


        public function getPrice():int
        {
            return $this->price;
        }
        public function setPrice(int $price): int
        {
            $this->price = $price;
        }
        public function getId() :int
        {
            return $this->id;
        }


        public function setId(int $id): void
        {
            $this->id = $id;
        }
        public function getName() :string
        {
            return $this->name;
        }
        public function setName( string $name): string
        {
            $this->name = $name;
        }
        public function getCategories() :array
        {
            return $this->categories;
        }

        public function setCategories(array $categories): void
        {
            $this->categories = $categories;
        }
        public function addCategory( Categories $categorie) :void {
            array_push( $this->categories , $categorie  );


        }
        public function removeCategory(Categories $categorie    ) :void{
            $val = array_search($categorie, $this->categories );
            unset($this->categories[$val]);


        }
    }