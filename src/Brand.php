<?php

    class Brand

    {

        private $brand_name;
        private $price;
        private $id;

        function __construct($brand_name, $price, $id = null)
        {
            $this->brand_name = $brand_name;
            $this->price = $price;
            $this->id = $id;
        }

        function getBrandName()
        {
            return $this->brand_name;
        }

        function setBrandName($new_brand_name)
        {
            $this->brand_name = (string) $new_brand_name;
        }

        function getPrice()
        {
            return $this->price;
        }

        function setPrice($new_price)
        {
            $this->price = (float) $new_price;
        }

        function save()
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO brands (brand_name, price) VALUES ('{$this->getBrandName()}', '{$this->getPrice()}')");
            if ($executed) {
                $this->id = $GLOBALS['DB']->lastInsertID();
                return true;
            } else {
                return false;
            }
        }

        function getID()
        {
            return $this->id;
        }

        static function getAll()
        {
            $returned_brands = $GLOBALS['DB']->query("SELECT * FROM brands");
            $brands = array();
            foreach($returned_brands as $brand) {
                $brand_name = $brand['brand_name'];
                $brand_price = $brand['price'];
                $brand_id = $brand['id'];
                $new_brand = new Brand($brand_name, $brand_price, $brand_id);
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
                $brand_price = $brand['price'];
                $brand_id = $brand['id'];
                if ($brand_id == $search_id) {
                    $returned_brand = new Brand($brand_name, $brand_price, $brand_id);
                }
            }
            return $returned_brand;
        }

        function updateBrandName($new_brand_name)
        {
            $executed = $GLOBALS['DB']->exec("UPDATE brands SET brand_name = '{$new_brand_name}' WHERE id = {$this->getID()};");
            if ($executed) {
                $this->setBrandName($new_brand_name);
                return true;
            } else {
                return false;
            }
        }

        function updatePrice($new_price)
        {
            $executed = $GLOBALS['DB']->exec("UPDATE brands SET price = '{$new_price}' WHERE id = {$this->getID()};");
            if ($executed) {
                $this->setPrice($new_price);
                return true;
            } else {
                return false;
            }
        }

        function delete()
        {
            $part_1 = $GLOBALS['DB']->exec("DELETE FROM brands WHERE id = {$this->getID()};");
            $part_2 = $GLOBALS['DB']->exec("DELETE FROM brands_stores WHERE brand_id = {$this->getID()};");
            $executed = $part_1 && $part_2;
            if ($executed) {
                return true;
            } else {
                return false;
            }
        }

        static function isDuplicateBrandName($search_brand_name)
        {
            $returned_brands = $GLOBALS['DB']->prepare("SELECT * FROM brands WHERE brand_name = :brand_name");
            $returned_brands->bindParam(':brand_name', $search_brand_name, PDO::PARAM_STR);
            $returned_brands->execute();
            foreach ($returned_brands as $brand) {
                $brand_name = $brand['brand_name'];
                $brand_price = $brand['price'];
                $brand_id = $brand['id'];
                if ($brand_name == $search_brand_name) {
                    $returned_brand = new Brand($brand_name, $brand_price, $brand_id);
                }
            }
            if (!(empty($returned_brand))){
                return true;
            } else {
                return false;
            }
        }

        function addStore($store)
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ({$this->getID()}, {$store->getID()});");
            if ($executed) {
                return true;
            } else {
                return false;
            }
        }

        function getStores()
        {
            $returned_stores = $GLOBALS['DB']->query("SELECT stores.* FROM brands JOIN brands_stores ON (brands_stores.brand_id = brands.id) JOIN stores ON (stores.id = brands_stores.store_id) WHERE brands.id = {$this->getID()};");
            $stores = array();
            foreach($returned_stores as $store) {
                $store_name = $store['store_name'];
                $store_id = $store['id'];
                $new_store = new Store($store_name, $store_id);
                array_push($stores, $new_store);
            }
            return $stores;
        }
    }
?>
