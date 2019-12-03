<?php

namespace App\Entity;

    class Products
    {


        private  $price;
        private $id;
        private $name;
        private $categories;

        /**
         * @return mixed
         */
        public function getPrice():int
        {
            return $this->price;
        }

        /**
         * @param mixed $price
         */
        public function setPrice(int $price): int
        {
            $this->price = $price;
        }

        /**
         * @return mixed
         */
        public function getId() :int
        {
            return $this->id;
        }

        /**
         * @param mixed $id
         */
        public function setId(int $id): void
        {
            $this->id = $id;
        }

        /**
         * @return mixed
         */
        public function getName() :string
        {
            return $this->name;
        }

        /**
         * @param mixed $name
         */
        public function setName( string $name): string
        {
            $this->name = $name;
        }

        /**
         * @return mixed
         */
        public function getCategories() :array
        {
            return $this->categories;
        }

        /**
         * @param mixed $categories
         */
        public function setCategories(array $categories): void
        {
            $this->categories = $categories;
        }

        public function addCategory( Categories $categorie) :void {

        }

        public function removeCategory(Categories $categorie    ) :void{

        }







    }