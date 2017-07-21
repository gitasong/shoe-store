<?php

    class Store
    {

        private $store_name;
        private $id;

        function __construct($store_name, $id = null)
        {
            $this->store_name = $store_name;
            $this->id = $id;
        }

        function getStoreName()
        {
            return $this->store_name;
        }

        function setStoreName($new_store_name)
        {
            $this->store_name = (string) $new_store_name;
        }

        function save()
        {
            $executed = $GLOBALS['DB']->exec("INSERT INTO stores (store_name) VALUES ('{$this->getStoreName()}')");
            if ($executed) {
                $this->id = $GLOBALS['DB']->lastInsertId();
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
            $returned_stores = $GLOBALS['DB']->query("SELECT * FROM stores");
            $stores = array();
            foreach($returned_stores as $store) {
                $store_name = $store['store_name'];
                $store_id = $store['id'];
                $new_store = new Store($store_name, $store_id);
                array_push($stores, $new_store);
            }
            return $stores;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores;");
        }

        static function find($search_id)
        {
            $returned_stores = $GLOBALS['DB']->prepare("SELECT * FROM stores WHERE id = :id");
            $returned_stores->bindParam(':id', $search_id, PDO::PARAM_STR);
            $returned_stores->execute();
            foreach ($returned_stores as $store) {
                $store_store_name = $store['store_name'];
                $store_id = $store['id'];
                if ($store_id == $search_id) {
                    $returned_store = new Store($store_store_name, $store_id);
                }
            }
            return $returned_store;
        }

        function updateStoreName($new_store_name)
        {
            $executed = $GLOBALS['DB']->exec("UPDATE stores SET store_name = '{$new_store_name}' WHERE id = {$this->getID()};");
            if ($executed) {
                $this->setStoreName($new_store_name);
                return true;
            } else {
                return false;
            }
        }

        // function delete()
        // {
        //     $executed = $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getID()};");
        //     if ($executed) {
        //         return true;
        //     } else {
        //         return false;
        //     }
        // }
        //
        // function addBrand($brand)
        // {
        //     $executed = $GLOBALS['DB']->exec("INSERT INTO brands_stores (store_id, brand_id) VALUES ({$this->getID()}, {$brand->getID()});");
        //     if ($executed) {
        //         return true;
        //     } else {
        //         return false;
        //     }
        // }
        //
        // function getBrands()
        // {
        //     $returned_brands = $GLOBALS['DB']->query("SELECT brands.* FROM stores JOIN brands_stores ON (brands_stores.store_id = store_id) JOIN brands ON (brands.id = brands_stores.brand_id) WHERE stores.id = {$this->getID()};");
        //     $brands = array();
        //     foreach($returned_brands as $brand) {
        //         $brand_name = $brand['brand_name'];
        //         $brand_price = $brand['price'];
        //         $brand_id = $brand['id'];
        //         $new_brand = new Brand($brand_name, $brand_id);
        //         array_push($brands, $new_brand);
        //     }
        //     return $brands;
        // }
        //
        // static function findStoreByName($search_store_name)
        // {
        //     $returned_stores = $GLOBALS['DB']->prepare("SELECT * FROM stores WHERE store_name = :store_name");
        //     $returned_stores->bindParam(':store_name', $search_store_name, PDO::PARAM_STR);
        //     $returned_stores->execute();
        //     foreach ($returned_stores as $store) {
        //         $store_name = $store['store_name'];
        //         $store_id = $store['id'];
        //         if ($store_name == $search_store_name) {
        //             $returned_store = new Store($store_name, $store_id);
        //         }
        //     }
        //     return $returned_store;
        // }

    }
?>
