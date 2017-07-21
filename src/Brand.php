<?php

    class Brand

    {

        private $brand_name;
        private $id;

        function __construct($brand_name, $id = null)
        {
            $this->brand_name = $brand_name;
            $this->id = $id;
        }

        function getTitle()
        {
            return $this->brand_name;
        }

        function setTitle($new_brand_name)
        {
            $this->brand_name = (string) $new_brand_name;
        }

        function save()
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO brands (brand_name) VALUES ('{$this->getTitle()}')");
            if ($executed) {
                $this->id = $GLOBALS['DB']->lastInsertId();
                return true;
            } else {
                return false;
            }
        }

        function getId()
        {
            return $this->id;
        }

        static function getAll()
        {
            $returned_brands = $GLOBALS['DB']->query("SELECT * FROM brands");
            $brands = array();
            foreach($returned_brands as $brand) {
                $brand_name = $brand['brand_name'];
                $brand_id = $brand['id'];
                $new_brand = new Brand($brand_name, $brand_id);
                array_push($brands, $new_brand);
            }
            return $brands;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands;");
        }

        static function find($search_id)
        {
            $returned_brands = $GLOBALS['DB']->prepare("SELECT * FROM brands WHERE id = :id");
            $returned_brands->bindParam(':id', $search_id, PDO::PARAM_STR);
            $returned_brands->execute();
            foreach ($returned_brands as $brand) {
                $brand_name = $brand['brand_name'];
                $brand_id = $brand['id'];
                if ($brand_id == $search_id) {
                    $returned_brand = new Brand($brand_name, $brand_id);
                }
            }
            return $returned_brand;
        }

        function updateTitle($new_brand_name)
        {
            $executed = $GLOBALS['DB']->exec("UPDATE brands SET brand_name = '{$new_brand_name}' WHERE id = {$this->getID()};");
            if ($executed) {
                $this->setTitle($new_brand_name);
                return true;
            } else {
                return false;
            }
        }

        function delete()
        {
            $executed = $GLOBALS['DB']->exec("DELETE FROM brands WHERE id = {$this->getID()};");
            if ($executed) {
                return true;
            } else {
                return false;
            }
        }

        function addStore($store)
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO stores_brands (brand_id, store_id) VALUES ({$this->getId()}, {$store->getId()});");
            if ($executed) {
                return true;
            } else {
                return false;
            }
        }

        function getStores()
        {
            $returned_stores = $GLOBALS['DB']->query("SELECT stores.* FROM brands JOIN stores_brands ON (stores_brands.brand_id = brands.id) JOIN stores ON (stores.id = stores_brands.store_id) WHERE brands.id = {$this->getId()};");
            $stores = array();
            foreach($returned_stores as $store) {
                $store_name = $store['store_name'];
                $store_id = $store['id'];
                $new_store = new Store($store_name, $store_id);
                array_push($stores, $new_store);
            }
            return $stores;
        }

        static function findBrandByTitle($search_brand_name)
        {
            $returned_brands = $GLOBALS['DB']->prepare("SELECT * FROM brands WHERE brand_name = :brand_name");
            $returned_brands->bindParam(':brand_name', $search_brand_name, PDO::PARAM_STR);
            $returned_brands->execute();
            foreach ($returned_brands as $brand) {
                $brand_name = $brand['brand_name'];
                $brand_id = $brand['id'];
                if ($brand_name == $search_brand_name) {
                    $returned_brand = new Brand($brand_name, $brand_id);
                }
            }
            return $returned_brand;
        }
    }
?>
