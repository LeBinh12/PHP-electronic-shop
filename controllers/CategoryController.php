
<?php

require_once './models/Category.php';
require_once './core/RedisCache.php';

class CategoryController
{
    private $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new Category();
    }

    public function getAll()
    {
        $key = 'categories:all';
        if (RedisCache::exists($key)) {
            return json_decode(RedisCache::get($key), true);
        }
        $data = $this->categoryModel->all();
        RedisCache::set($key, json_encode($data));
        return $data;
    }

    public function getById($id)
    {
        $key = "category:$id";
        if (RedisCache::exists($key)) {
            return json_decode(RedisCache::get($key), true);
        }
        $data = $this->categoryModel->find($id);
        RedisCache::set($key, json_encode($data));
        return $data;
    }

    public function getFilterCategories($limit, $offset, $keyword)
    {
        $key = "categories:filter:$limit:$offset:$keyword";
        if (RedisCache::exists($key)) {
            return json_decode(RedisCache::get($key), true);
        }
        $data = $this->categoryModel->getFilteredCategories($limit, $offset, $keyword);
        RedisCache::set($key, json_encode($data));
        return $data;
    }

    public function countCategories($keyword = '')
    {
        $key = "categories:count:$keyword";
        if (RedisCache::exists($key)) {
            return (int) RedisCache::get($key);
        }
        $total = $this->categoryModel->countCategory($keyword);
        RedisCache::set($key, $total);
        return $total;
    }

    public function add($data)
    {
        if ($this->categoryModel->existsByName($data['name'])) {
            return [
                'success' => false,
                'message' => 'Tên thể loại đã tồn tại!'
            ];
        }
        $category = $this->categoryModel->insert($data);
        $this->invalidateCache();
        return [
            'success' => true,
            'message' => 'Thêm thể loại thành công',
            'category' => $category
        ];
    }

    public function edit($id, $data)
    {
        $existingcategory = $this->categoryModel->find($id);
        if ($existingcategory == null) {
            return [
                'success' => false,
                'message' => 'thể loại không tồn tại!'
            ];
        }

        if ($data['name'] != $existingcategory['name']) {
            if ($this->categoryModel->existsByName($data['name'])) {
                return [
                    'success' => false,
                    'message' => 'Tên thể loại đã tồn tại!'
                ];
            }
        }
        $categoryEdit = $this->categoryModel->update($id, $data);
        $this->invalidateCache($id);
        return [
            'success' => true,
            'message' => 'Cập nhật thể loại thành công!',
            'category' => $categoryEdit
        ];
    }

    public function delete($id)
    {
        $categoryDelete = $this->categoryModel->updateDeleted($id);
        $this->invalidateCache($id);
        return $categoryDelete;
    }

    private function invalidateCache($id = null)
    {
        RedisCache::delete('categories:all');
        RedisCache::delete('categories:filter');

        $filterKeys = RedisCache::keys('categories:filter:*');
        $countKeys = RedisCache::keys('categories:count:*');

        foreach (array_merge($filterKeys, $countKeys) as $key) {
            RedisCache::delete($key);
        }

        if ($id !== null) {
            RedisCache::delete("category:$id");
        }
    }
}
