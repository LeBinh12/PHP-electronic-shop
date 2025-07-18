<?php
require_once './models/Product.php';
require_once './core/RedisCache.php';
require_once './controllers/BaseController.php';

use Respect\Validation\Validator as v;

class ProductController extends BaseController
{
    private $productModel;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
    }

    public function getAll()
    {

        $cacheKey = 'products:all';
        if (RedisCache::exists($cacheKey)) {
            return json_decode(RedisCache::get($cacheKey), true);
        }


        $products = $this->productModel->all();
        RedisCache::set($cacheKey, json_encode($products));

        return $products;
        // return $this->productModel->all();
    }

    public function getLatestProducts($limit = 20)
    {
        $cacheKey = "products:latest:$limit";
        if (RedisCache::exists($cacheKey)) {
            return json_decode(RedisCache::get($cacheKey), true);
        }

        $products = $this->productModel->getLatestProducts($limit);
        RedisCache::set($cacheKey, json_encode($products));

        return $products;
    }

    public function getLatestSaleProducts($limit = 20)
    {
        $cacheKey = "products:latest_sale:$limit";
        if (RedisCache::exists($cacheKey)) {
            return json_decode(RedisCache::get($cacheKey), true);
        }

        $products = $this->productModel->getLatestSaleProducts($limit);
        RedisCache::set($cacheKey, json_encode($products));

        return $products;
    }



    public function getById($id)
    {
        $cacheKey = "products:{$id}";
        if (RedisCache::exists($cacheKey)) {
            return json_decode(RedisCache::get($cacheKey), true);
        }

        $product = $this->productModel->find($id);
        RedisCache::set($cacheKey, json_encode($product));
        return $product;
        // return $this->productModel->find($id);
    }

    public function getByIdToDB($id)
    {
        return $this->productModel->find($id);
    }

    public function getProductByCategory($id)
    {
        $cacheKey = "products:category:{$id}";
        if (RedisCache::exists($cacheKey)) {
            return json_decode(RedisCache::get($cacheKey), true);
        }

        $products = $this->productModel->getProductsByCategory($id);
        RedisCache::set($cacheKey, json_encode($products));
        return $products;
        // return $this->productModel->getProductsByCategory($id);
    }

    public function getFilterProducts($categoryId, $supplierId, $keyword, $limit = 8, $offset = 0, array $priceRanges = [])
    {
        $start = microtime(true);
        $priceKey = implode(',', $priceRanges);
        $cacheKey = "products:filter:$categoryId:$supplierId:$keyword:$priceKey:$limit:$offset";
        if (RedisCache::exists($cacheKey)) {

            $end = microtime(true);
            echo "⏱ Thời gian xử lý: " . round(($end - $start) * 1000, 2) . " ms";
            return json_decode(RedisCache::get($cacheKey), true);
        }

        $products = $this->productModel->getFilteredProducts($categoryId, $supplierId, $keyword, $limit, $offset, $priceRanges);
        RedisCache::set($cacheKey, json_encode($products));

        $end = microtime(true);
        echo "⏱ Thời gian xử lý: " . round(($end - $start) * 1000, 2) . " ms";

        return $products;
        // return $this->productModel->getFilteredProducts($categoryId, $supplierId, $keyword, $limit, $offset);
    }

    public function countProducts($categoryId, $supplierId, $keyword, array $priceRanges = [])
    {
        $priceKey = implode(',', $priceRanges);
        $cacheKey = "products:count:$categoryId:$supplierId:$keyword:$priceKey";
        if (RedisCache::exists($cacheKey)) {
            return json_decode(RedisCache::get($cacheKey), true);
        }

        $total = $this->productModel->countFilteredProducts($categoryId, $supplierId, $keyword,);
        RedisCache::set($cacheKey, json_encode($total));
        return $total;
        // return $this->productModel->countFilteredProducts($categoryId, $supplierId, $keyword);
    }

    public function add($data)
    {
        $rules = [
            'name'          => v::stringType()->length(3, 100)
                ->setTemplate('Tên SP phải 3‑100 ký tự'),
            'price'         => v::number()->positive()
                ->setTemplate('Giá phải là số dương'),
            'discount'      => v::intVal()->between(0, 100)
                ->setTemplate('Giảm giá 0‑100%'),

            'content' => v::stringType()->length(0, 500)
                ->setTemplate("Mô tả ngắn phải 0-500 ký tự"),
        ];

        if (!$this->validator->validate($data, $rules)) {
            return [
                'success' => false,
                'errors'  => $this->validator->error()
            ];
        }


        if ($this->productModel->existsByName($data['name'])) {
            return [
                'success' => false,
                'message'  => 'Tên sản phẩm đã tồn tại'
            ];
        }
        $productId = $this->productModel->insert($data);
        $this->clearCacheAfterChange($productId);
        return [
            'success' => true,
            'message' => 'Thêm sản phẩm thành công',
            'product' => $productId
        ];
    }


    public function edit($id, $data)
    {

        $rules = [
            'name'          => v::stringType()->length(3, 100)
                ->setTemplate('Tên SP phải 3‑100 ký tự'),
            'price'         => v::number()->positive()
                ->setTemplate('Giá phải là số dương'),
            'discount'      => v::intVal()->between(0, 100)
                ->setTemplate('Giảm giá 0‑100%'),

            'content' => v::stringType()->length(0, 500)
                ->setTemplate("Mô tả ngắn phải 0-500 ký tự"),
        ];

        if (!$this->validator->validate($data, $rules)) {
            return [
                'success' => false,
                'errors'  => $this->validator->error()
            ];
        }

        $existingProduct = $this->productModel->find($id);
        if ($existingProduct == null) {
            return [
                'success' => false,
                'message' => 'Sản phẩm không tồn tại!'
            ];
        }

        if ($data['name'] != $existingProduct['name']) {
            if ($this->productModel->existsByName($data['name'])) {
                return [
                    'success' => false,
                    'message' => 'Tên sản phẩm đã tồn tại!'
                ];
            }
        }

        $productEdit = $this->productModel->update($id, $data);
        $this->clearCacheAfterChange($id);
        return [
            'success' => true,
            'message' => 'Cập nhật sản phẩm thành công!',
            'product' => $productEdit
        ];
    }



    public function delete($id)
    {
        $deleted = $this->productModel->updateDeleted($id);
        $this->clearCacheAfterChange($id);
        return [
            'success' => true,
            'message' => 'Xóa sản phẩm thành công!',
        ];
    }

    private function clearCacheAfterChange($id)
    {
        RedisCache::delete("products:all");
        $filterKeys = RedisCache::keys('products:filter:*');
        $countKeys = RedisCache::keys('products:count:*');

        foreach (array_merge($filterKeys, $countKeys) as $key) {
            RedisCache::delete($key);
        }
        if ($id !== null)
            RedisCache::delete("product:$id");
    }
}
