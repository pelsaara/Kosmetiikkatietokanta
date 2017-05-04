<?php

class ProductController extends BaseController {

    public static function listAll() {
        $products = Product::all();
        View::make('product/list.html', array('products' => $products));
    }

    public static function show($id) {
        $product = Product::find($id);
        if ($product != NULL) {
            View::make('product/show.html', array('product' => $product));
        } else {
            Redirect::to('/product', array('error' => 'Tuotetta ei löydy!'));
        }
    }

    public static function create() {
        self::check_logged_in();
        $brands = Brand::all();
        $categories = Category::all();
        View::make('product/new.html', array('brands' => $brands, 'categories' => $categories));
    }

    public static function store() {
        self::check_logged_in();
        $params = $_POST;

        $boolean = 0;
        if (isset($params['categories'])) {
            $boolean = 1;
        }
        if ($boolean == 1) {
            $categories = $params['categories'];
        }
        $attributes = array(
            'name' => $params['name'],
            'brand' => $params['brand'],
            'description' => $params['description'],
            'ingredients' => $params['ingredients'],
            'categories' => array()
        );

        if ($boolean == 1) {
            foreach ($categories as $category) {
                $attributes['categories'][] = $category;
            }
        }

        $product = new Product($attributes);

        $errors = $product->errors();
        if (count($errors) == 0) {
            $product->save();
            if ($boolean == 1) {
                foreach ($categories as $category) {
                    $pc = new ProductCategory(array('product_id' => $product->id, 'category_id' => $category));
                    $pc->save();
                }
            }

            Redirect::to('/product/' . $product->id, array('message' => 'Tuote on lisätty tietokantaan!'));
        } else {
            $brands = Brand::all();
            View::make('/product/new.html', array('errors' => $errors, 'attributes' => $attributes, 'brands' => $brands));
        }
    }

    public static function edit($id) {
        self::check_logged_in();
        $product = Product::find($id);
        $brands = Brand::all();
        $categories = Category::all();
        $productCategories = ProductCategory::productCategories($id);
        $pcIDs = array();
        foreach ($productCategories as $p) {
            $pcIDs[] = $p->category_id;
        }

        View::make('product/edit.html', array('attributes' => $product, 'brands' => $brands, 'categories' => $categories, 'productCategories' => $pcIDs));
    }

    public static function update($id) {
        self::check_logged_in();
        $params = $_POST;
        $boolean = 0;
        if (isset($params['categories'])) {
            $boolean = 1;
        }
        if ($boolean == 1) {
            $categories = $params['categories'];
        }

        $attributes = array(
            'id' => $id,
            'name' => $params['name'],
            'brand' => $params['brand'],
            'description' => $params['description'],
            'ingredients' => $params['ingredients'],
            'categories' => array()
        );

        if ($boolean == 1) {
            foreach ($categories as $category) {
                $attributes['categories'][] = $category;
            }
        }
        $product = new Product($attributes);
        $errors = $product->errors();

        if (count($errors) > 0) {
            $brands = Brand::all();
            $categories = Category::all();
            $productCategories = ProductCategory::productCategories($id);
            $pcIDs = array();
            foreach ($productCategories as $p) {
                $pcIDs[] = $p->category_id;
            }
            View::make('product/edit.html', array('errors' => $errors, 'attributes' => $product, 'brands' => $brands, 'categories' => $categories, 'productCategories' => $pcIDs));
        } else {
            $product->update();
            if ($boolean == 1) {


                ProductCategory::destroyById($product->id);
                foreach ($categories as $category) {
                    $pc = new ProductCategory(array('product_id' => $product->id, 'category_id' => $category));
                    $pc->save();
                }
            }
            Redirect::to('/product/' . $product->id, array('message' => 'Tuotetta on muokattu onnistuneesti!'));
        }
    }

    public static function destroy($id) {
        self::check_logged_in();
        $product = new Product(array('id' => $id));
        $product->delete();

        Redirect::to('/product', array('message' => 'Tuote on poistettu onnistuneesti!'));
    }

}
