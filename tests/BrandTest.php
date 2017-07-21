<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Brand.php";
    // require_once "src/Store.php";

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
            $test_brand = new Brand($brand_name);

            $result = $test_brand->getBrandName();

            $this->assertEquals($brand_name, $result);
        }

        function testSetBrandName()
        {
            $brand_name = "Adidas";
            $test_brand = new Brand($brand_name);
            $new_brand_name = "Nike";

            $test_brand->setBrandName($new_brand_name);
            $result = $test_brand->getBrandName();

            $this->assertEquals($new_brand_name, $result);
        }

        function testSave()
        {
            $brand_name = "Reebok";
            $test_brand = new Brand($brand_name);

            $executed = $test_brand->save();

            $this->assertTrue($executed, "Brand not successfully saved to database");
        }

        function testGetId()
        {
            $brand_name = "Timberland";
            $test_brand = new Brand($brand_name);
            $test_brand->save();

            $result = $test_brand->getId();

            $this->assertEquals(true, is_numeric($result));
        }

        function testGetAll()
        {
            $brand_name_1 = "backupStaticAttributes";
            $test_brand_1 = new Brand($brand_name_1);
            $test_brand_1->save();

            $brand_name_2 = "Clarks";
            $test_brand_2 = new Brand($brand_name_2);
            $test_brand_2->save();

            $result = Brand::getAll();

            $this->assertEquals([$test_brand_1, $test_brand_2], $result);
        }

        function testDeleteAll()
        {
            $brand_name_1 = "Naturalizer";
            $test_brand_1 = new Brand($brand_name_1);
            $test_brand_1->save();

            $brand_name_2 = "Nine West";
            $test_brand_2 = new Brand($brand_name_2);
            $test_brand_2->save();

            Brand::deleteAll();
            $result = Brand::getAll();

            $this->assertEquals([], $result);
        }

        function testFind()
        {
            $brand_name_1 = "Mephisto";
            $test_brand_1 = new Brand($brand_name_1);
            $test_brand_1->save();

            $brand_name_2 = "Birkenstock";
            $test_brand_2 = new Brand($brand_name_2);
            $test_brand_2->save();

            $result = Brand::find($test_brand_2->getId());

            $this->assertEquals($test_brand_2, $result);
        }

        function testUpdateBrandName()
        {
            $brand_name = "Reebok";
            $test_brand = new Brand($brand_name);
            $test_brand->save();
            $new_brand_name = "New Balance";

            $test_brand->updateBrandName($new_brand_name);

            $this->assertEquals("New Balance", $test_brand->getBrandName());
        }

        function testDelete()
        {
            $brand_name_1 = "Kenneth Cole";
            $test_brand_1 = new Brand($brand_name_1);
            $test_brand_1->save();

            $brand_name_2 = "Manolo Blahnik";
            $test_brand_2 = new Brand($brand_name_2);
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
        //     $test_brand = new Brand($brand_name);
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
        //     $brand_name = "Dansko?";
        //     $test_brand = new Brand($brand_name);
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
        //     $test_brand_1 = new Brand($brand_name_1);
        //     $test_brand_1->save();
        //
        //     $brand_name_2 = "Minnetonka";
        //     $test_brand_2 = new Brand($brand_name_2);
        //     $test_brand_2->save();
        //
        //     $result = Brand::findBrandByBrandName($test_brand_2->getBrandName());
        //
        //     $this->assertEquals($test_brand_2, $result);
        // }
    }
?>
