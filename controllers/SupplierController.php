<?php

require_once './models/Supplier.php';
require_once './core/RedisCache.php';

class SupplierController
{
    private $supplierModel;

    public function __construct()
    {
        $this->supplierModel = new Supplier();
    }

    public function getAll()
    {
        $cacheKey = 'supplier:all';
        if (RedisCache::exists($cacheKey)) {
            return json_decode(RedisCache::get($cacheKey), true);
        }
        $suppliers = $this->supplierModel->all();
        RedisCache::set($cacheKey, json_encode($suppliers));
        return $suppliers;
    }

    public function getById($id)
    {
        $cacheKey = "supplier:$id";
        if (RedisCache::exists($cacheKey)) {
            return json_decode(RedisCache::get($cacheKey), true);
        }
        $supplier = $this->supplierModel->find($id);
        RedisCache::set($cacheKey, json_encode($supplier));
        return $supplier;
    }

    public function getFilterSuppliers($limit, $offset, $keyword)
    {
        $cacheKey = "suppliers:filter:$limit:$offset:$keyword";
        if (RedisCache::exists($cacheKey)) {
            return json_decode(RedisCache::get($cacheKey), true);
        }
        $suppliers = $this->supplierModel->getFilteredSuppliers($limit, $offset, $keyword);
        RedisCache::set($cacheKey, json_encode($suppliers));
        return $suppliers;
    }

    public function countSuppliers($keyword = '')
    {
        $cacheKey = "suppliers:count:$keyword";
        if (RedisCache::exists($cacheKey)) {
            return (int) RedisCache::get($cacheKey);
        }
        $total = $this->supplierModel->countSupplier($keyword);
        RedisCache::set($cacheKey, $total);
        return $total;
    }

    public function add($data)
    {
        try {
            if ($this->supplierModel->existsByName($data['name'])) {
                return [
                    'success' => false,
                    'message' => 'Tên nhà cung cấp đã tồn tại!'
                ];
            }
            $supplier = $this->supplierModel->insert($data);
            $this->invalidateCache($supplier);
            return [
                'success' => true,
                'message' => 'Thêm nhà cung cấp thành công',
                'supplier' => $supplier
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function edit($id, $data)
    {
        try {
            $existingSupplier = $this->supplierModel->find($id);
            if ($existingSupplier == null) {
                return [
                    'success' => false,
                    'message' => 'nhà cung cấp không tồn tại!'
                ];
            }

            $existingByName = $this->supplierModel->existsByNameExceptId($id, $data['name']);
            if ($existingByName) {
                return [
                    'success' => false,
                    'message' => 'Tên sản phẩm này đã tồn tại, vui lòng chọn tên khác.'
                ];
            }

            $supplierEdit = $this->supplierModel->update($id, $data);
            $this->invalidateCache($id);

            return [
                'success' => true,
                'message' => 'Cập nhật nhà cung cấp thành công!',
                'supplier' => $supplierEdit
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function delete($id)
    {
        try {
            $supplierDelete = $this->supplierModel->updateDeleted($id);
            $this->invalidateCache($id);

            return [
                'success' => true,
                'message' => 'Xóa nhà cung cấp thành công!',
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    private function invalidateCache($id = null)
    {
        RedisCache::delete('suppliers:all');
        $filterKeys = RedisCache::keys('suppliers:filter:*');
        $countKeys = RedisCache::keys('suppliers:count:*');

        foreach (array_merge($filterKeys, $countKeys) as $key) {
            RedisCache::delete($key);
        }
        if ($id) RedisCache::delete("supplier:$id");
    }
}
