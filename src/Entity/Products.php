<?php

    namespace App\Entity;

    use App\Model;

    class Products
    {
        private int $price;
        private int $id;
        private  string $name;
        private  $categories;


        public function getPrice():int
        {
            return $this->price;
        }

        /**
         * @param int $price
         * @return int
         */
        public function setPrice(int $price): int
        {
            $this->price = $price;
        }

        /**
         * @return int
         */
        public function getId() :int
        {
            return $this->id;
        }

        /**
         * @param int $id
         */
        public function setId(int $id): void
        {
            $this->id = $id;
        }
        /**
         * @return int
         */
        public function getName() :string
        {
            return $this->name;
        }

        /**
         * @param string $name
         * @return string
         */
        public function setName( string $name): string
        {
            $this->name = $name;
        }
        /**
         * @return string
         */
        public function getCategories() :array
        {
            return $this->categories;
        }
        /**
         * @param array $categories
         */
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