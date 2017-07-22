<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Store.php";
    require_once __DIR__."/../src/Brand.php";

    use Symfony\Component\Debug\Debug;
    Debug::enable();

    $server = 'mysql:host=localhost:8889;dbname=shoe_store';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app = new Silex\Application();

    $app['debug'] = true;

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app) {
        return $app['twig']->render('stores.html.twig', array('all_stores' => Store::getAll()));
    });

    $app->post("/add_store", function() use ($app) {
        $new_store_name = $_POST['store_name'];
        $isDuplicate = Store::isDuplicateStoreName($new_store_name);
        if (!($isDuplicate)) {
            $new_store = new Store($new_store_name);
            $new_store->save();
        }
        return $app['twig']->render('stores.html.twig', array('all_stores' => Store::getAll()));
    });

    $app->get("/store/{id}", function($id) use ($app) {
        $store = Store::find($id);
        return $app['twig']->render('store.html.twig', array('store' => $store, 'all_brands' => Brand::getAll(), 'store_brands' => $store->getBrands()));
    });

    $app->post("/edit_store/{id}", function($id) use ($app) {
        $store = Store::find($id);
        return $app['twig']->render('store.html.twig', array('store' => $store));
    });

    $app->patch("/edit_store/{id}", function($id) use ($app) {
        $new_store_name = $_POST['store_name'];
        $store = Store::find($id);
        $store->updateStoreName($new_store_name);
        return $app['twig']->render('store.html.twig', array('store' => $store));
    });

    $app->delete("/delete_store/{id}", function($id) use ($app) {
        $store = Store::find($id);
        $store->delete();
        return $app['twig']->render('stores.html.twig', array('all_stores' => Store::getAll()));
    });

    $app->get("/brands", function() use ($app) {
        return $app['twig']->render('brands.html.twig', array('all_brands' => Brand::getAll()));
    });

    $app->post("/add_brand", function() use ($app) {
        $new_brand_name = $_POST['brand_name'];
        $new_price = $_POST['price'];
        $new_brand = new Brand($new_brand_name, $new_price);
        $new_brand->save();
        return $app['twig']->render('brands.html.twig', array('all_brands' => Brand::getAll()));
    });

    $app->post("/assign_brand/{id}", function($id) use ($app) {
        $store = Store::find($id);
        $brand = Brand::find($_POST['all_brands']);
        $store->addBrand($brand);
        return $app['twig']->render('store.html.twig', array('store' => $store, 'all_brands' => Brand::getAll(), 'store_brands' => $store->getBrands()));
    });

    $app->delete("/delete_brand/{id}", function($id) use ($app) {
        $brand = Brand::find($id);
        $brand->delete();
        return $app['twig']->render('brands.html.twig', array('all_brands' => Brand::getAll()));
    });

    return $app;

?>
