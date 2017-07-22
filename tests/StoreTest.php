<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Store.php";
    require_once "src/Brand.php";

    $server = 'mysql:host=localhost:8889;dbname=shoe_store_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StoreTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Store::deleteAll();
            Brand::deleteAll();
        }

        function testGetStoreName()
        {
            $store_name = "Macys";
            $test_store = new Store($store_name);

            $result = $test_store->getStoreName();

            $this->assertEquals($store_name, $result);
        }

        function testSetStoreName()
        {
            $store_name = "TJ Maxx";
            $test_store = new Store($store_name);
            $new_store_name = "Top Shoes";
            $test_store->setStoreName($new_store_name);

            $result = $test_store->getStoreName();

            $this->assertEquals($new_store_name, $result);
        }

        function testSave()
        {
            $store_name = "PayLess";
            $test_store = new Store($store_name);

            $executed = $test_store->save();

            $this->assertTrue($executed, "Store not successfully saved to database");
        }

        function testGetID()
        {
            $store_name = "Famous Brands";
            $test_store = new Store($store_name);
            $test_store->save();

            $result = $test_store->getID();

            $this->assertEquals(true, is_numeric($result));
        }

        function testGetAll()
        {
            $store_name_1 = "Macys";
            $test_store_1 = new Store($store_name_1);
            $test_store_1->save();

            $store_name_2 = "TJ Maxx";
            $test_store_2 = new Store($store_name_2);
            $test_store_2->save();

            $result = Store::getAll();

            $this->assertEquals([$test_store_1, $test_store_2], $result);
        }

        function testDeleteAll()
        {
            $store_name_1 = "Famous Brands";
            $test_store_1 = new Store($store_name_1);
            $test_store_1->save();

            $store_name_2 = "Top Shoes";
            $test_store_2 = new Store($store_name_2);
            $test_store_2->save();

            Store::deleteAll();
            $result = Store::getAll();

            $this->assertEquals([], $result);
        }

        function testFind()
        {
            $store_name_1 = "Famous Brands";
            $test_store_1 = new Store($store_name_1);
            $test_store_1->save();

            $store_name_2 = "Top Shoes";
            $test_store_2 = new Store($store_name_2);
            $test_store_2->save();

            $result = Store::find($test_store_2->getID());

            $this->assertEquals($test_store_2, $result);
        }

        function testUpdateStoreName()
        {
            $store_name = "PayLess";
            $test_store = new Store($store_name);
            $test_store->save();
            $new_store_name = "Famous Brands";

            $test_store->updateStoreName($new_store_name);

            $this->assertEquals("Famous Brands", $test_store->getStoreName());
        }

        function testDelete()
        {
            $store_name_1 = "Macys";
            $test_store_1 = new Store($store_name_1);
            $test_store_1->save();

            $store_name_2 = "TJ Maxx";
            $test_store_2 = new Store($store_name_2);
            $test_store_2->save();

            $test_store_1->delete();

            $this->assertEquals([$test_store_2], Store::getAll());
        }

        function testAddBrand()
        {
            $brand_name = "Adidas";
            $price = number_format(69.99, 2);
            $test_brand = new Brand($brand_name, $price);
            $test_brand->save();

            $store_name = "Top Shoes";
            $test_store = new Store($store_name);
            $test_store->save();

            $test_store->addBrand($test_brand);

            $this->assertEquals($test_store->getBrands(), [$test_brand]);
        }

        function testGetBrands()
        {
            $brand_name_1 = "Adidas";
            $price_1 = number_format(69.99, 2);
            $test_brand_1 = new Brand($brand_name_1, $price_1);
            $test_brand_1->save();

            $brand_name_2 = "Nike";
            $price_2 = number_format(79.99, 2);
            $test_brand_2 = new Brand($brand_name_2, $price_2);
            $test_brand_2->save();

            $store_name = "Top Shoes";
            $test_store = new Store($store_name);
            $test_store->save();

            $test_store->addBrand($test_brand_1);
            $test_store->addBrand($test_brand_2);

            $this->assertEquals($test_store->getBrands(), [$test_brand_1, $test_brand_2]);
        }

        function testFindStoreByName()
        {
            $store_name_1 = "Macys";
            $test_store_1 = new Store($store_name_1);
            $test_store_1->save();

            $store_name_2 = "TJ Maxx";
            $test_store_2 = new Store($store_name_2);
            $test_store_2->save();

            $result = Store::findStoreByName($test_store_2->getStoreName());

            $this->assertEquals($test_store_2, $result);
        }

        function testisDuplicateStoreName()
        {
            $store_name_1 = "Macys";
            $test_store_1 = new Store($store_name_1);
            $test_store_1->save();

            $store_name_2 = "TJ Maxx";
            $test_store_2 = new Store($store_name_2);
            $test_store_2->save();

            $result = Store::isDuplicateStoreName($test_store_2->getStoreName());

            $this->assertEquals(true, $result);
        }
    }
?>
