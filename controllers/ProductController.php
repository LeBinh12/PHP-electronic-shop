<?php
require_once './models/Product.php';
require_once './core/RedisCache.php';


class ProductController
{
    private $productModel;

    public function __construct()
    {
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

    public function getFilterProducts($categoryId, $supplierId, $keyword, $limit = 8, $offset = 0)
    {
        $start = microtime(true);

        $cacheKey = "products:filter:$categoryId:$supplierId:$keyword:$limit:$offset";
        if (RedisCache::exists($cacheKey)) {

            $end = microtime(true);
            echo "⏱ Thời gian xử lý: " . round(($end - $start) * 1000, 2) . " ms";
            return json_decode(RedisCache::get($cacheKey), true);
        }

        $products = $this->productModel->getFilteredProducts($categoryId, $supplierId, $keyword, $limit, $offset);
        RedisCache::set($cacheKey, json_encode($products));

        $end = microtime(true);
        echo "⏱ Thời gian xử lý: " . round(($end - $start) * 1000, 2) . " ms";

        return $products;
        // return $this->productModel->getFilteredProducts($categoryId, $supplierId, $keyword, $limit, $offset);
    }

    public function countProducts($categoryId, $supplierId, $keyword)
    {
        $cacheKey = "products:count:$categoryId:$supplierId:$keyword";
        if (RedisCache::exists($cacheKey)) {
            return json_decode(RedisCache::get($cacheKey), true);
        }

        $total = $this->productModel->countFilteredProducts($categoryId, $supplierId, $keyword);
        RedisCache::set($cacheKey, json_encode($total));
        return $total;
        // return $this->productModel->countFilteredProducts($categoryId, $supplierId, $keyword);
    }

    public function add($data)
    {
        if ($this->productModel->existsByName($data['name'])) {
            return [
                'success' => false,
                'message' => 'Tên sản phẩm đã tồn tại!'
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
        return $deleted;
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
