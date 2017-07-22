<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Brand.php";
    require_once "src/Store.php";

    $server = 'mysql:host=localhost:8889;dbname=shoe_store_test';
    $username = 'root';
    $password = 'root';

    $DB = new PDO($server, $username, $password);

    class BrandTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Brand::deleteAll();
            // Store::deleteAll();
        }

        function testGetBrandName()
        {
            $brand_name = "Adidas";
            $price = "69.99";
            $test_brand = new Brand($brand_name, $price);

            $result = $test_brand->getBrandName();

            $this->assertEquals($brand_name, $result);
        }

        function testSetBrandName()
        {
            $brand_name = "Adidas";
            $price = "69.99";
            $test_brand = new Brand($brand_name, $price);
            $new_brand_name = "Nike";

            $test_brand->setBrandName($new_brand_name);
            $result = $test_brand->getBrandName();

            $this->assertEquals($new_brand_name, $result);
        }

        function testGetPrice()
        {
            $brand_name = "Adidas";
            $price = "69.99";
            $test_brand = new Brand($brand_name, $price);

            $result = $test_brand->getPrice();

            $this->assertEquals($price, $result);
        }

        function testSetPrice()
        {
            $brand_name = "Adidas";
            $price = "69.99";
            $test_brand = new Brand($brand_name, $price);
            $new_price = "59.99";

            $test_brand->setPrice($new_price);
            $result = $test_brand->getPrice();

            $this->assertEquals($new_price, $result);
        }

        function testSave()
        {
            $brand_name = "Reebok";
            $price = "79.99";
            $test_brand = new Brand($brand_name, $price);

            $executed = $test_brand->save();

            $this->assertTrue($executed, "Brand not successfully saved to database");
        }

        function testGetID()
        {
            $brand_name = "Timberland";
            $price = "89.99";
            $test_brand = new Brand($brand_name, $price);
            $test_brand->save();

            $result = $test_brand->getID();

            $this->assertEquals(true, is_numeric($result));
        }

        function testGetAll()
        {
            $brand_name_1 = "Bass";
            $price_1 = "89.99";
            $test_brand_1 = new Brand($brand_name_1, $price_1);
            $test_brand_1->save();

            $brand_name_2 = "Clarks";
            $price_2 = "109.99";
            $test_brand_2 = new Brand($brand_name_2, $price_2);
            $test_brand_2->save();

            $result = Brand::getAll();

            $this->assertEquals([$test_brand_1, $test_brand_2], $result);
        }

        function testDeleteAll()
        {
            $brand_name_1 = "Naturalizer";
            $price_1 = "79.99";
            $test_brand_1 = new Brand($brand_name_1, $price_1);
            $test_brand_1->save();

            $brand_name_2 = "Nine West";
            $price_2 = "89.99";
            $test_brand_2 = new Brand($brand_name_2, $price_2);
            $test_brand_2->save();

            Brand::deleteAll();
            $result = Brand::getAll();

            $this->assertEquals([], $result);
        }

        function testFind()
        {
            $brand_name_1 = "Mephisto";
            $price_1 = "139.99";
            $test_brand_1 = new Brand($brand_name_1, $price_1);
            $test_brand_1->save();

            $brand_name_2 = "Birkenstock";
            $price_2 = "129.99";
            $test_brand_2 = new Brand($brand_name_2, $price_2);
            $test_brand_2->save();

            $result = Brand::find($test_brand_2->getID());

            $this->assertEquals($test_brand_2, $result);
        }

        function testUpdateBrandName()
        {
            $brand_name = "Reebok";
            $price = "49.99";
            $test_brand = new Brand($brand_name, $price);
            $test_brand->save();
            $new_brand_name = "New Balance";

            $test_brand->updateBrandName($new_brand_name);

            $this->assertEquals("New Balance", $test_brand->getBrandName());
        }

        function testUpdatePrice()
        {
            $brand_name = "Reebok";
            $price = "49.99";
            $test_brand = new Brand($brand_name, $price);
            $test_brand->save();
            $new_price = "59.99";

            $test_brand->updatePrice($new_price);

            $this->assertEquals("59.99", $test_brand->getPrice());
        }

        function testDelete()
        {
            $brand_name_1 = "Kenneth Cole";
            $price_1 = "129.99";
            $test_brand_1 = new Brand($brand_name_1, $price_1);
            $test_brand_1->save();

            $brand_name_2 = "Manolo Blahnik";
            $price_2 = "139.99";
            $test_brand_2 = new Brand($brand_name_2, $price_2);
            $test_brand_2->save();

            $test_brand_1->delete();

            $this->assertEquals([$test_brand_2], Brand::getAll());
        }

        // function testAddStore()
        // {
        //     $store_name = "Macys";
        //     $test_store = new Store($store_name);
        //     $test_store->save();
        //
        //     $brand_name = "Nine West";
        //     $price = "99.99";
        //     $test_brand = new Brand($brand_name, $price);
        //     $test_brand->save();
        //
        //     $test_brand->addStore($test_store);
        //
        //     $this->assertEquals($test_brand->getStores(), [$test_store]);
        // }
        //
        // function testGetStores()
        // {
        //     $store_name = "Top Shoes";
        //     $test_store = new Store($store_name);
        //     $test_store->save();
        //
        //     $store_name_2 = "PayLess";
        //     $test_store_2 = new Store($store_name_2);
        //     $test_store_2->save();
        //
        //     $brand_name = "Dansko";
        //     $price = "79.99";
        //     $test_brand = new Brand($brand_name, $price);
        //     $test_brand->save();
        //
        //     $test_brand->addStore($test_store);
        //     $test_brand->addStore($test_store_2);
        //
        //     $this->assertEquals($test_brand->getStores(), [$test_store, $test_store_2]);
        // }
        //
        // function testFindBrandByBrandName()
        // {
        //     $brand_name_1 = "Merrell";
        //     $price = "89.99";
        //     $test_brand_1 = new Brand($brand_name_1, $price_1);
        //     $test_brand_1->save();
        //
        //     $brand_name_2 = "Minnetonka";
        //     $price = "79.99";
        //     $test_brand_2 = new Brand($brand_name_2, $price_2);
        //     $test_brand_2->save();
        //
        //     $result = Brand::findBrandByBrandName($test_brand_2->getBrandName());
        //
        //     $this->assertEquals($test_brand_2, $result);
        // }
    }
?>
