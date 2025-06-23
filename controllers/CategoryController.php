
<?php

require_once './models/Category.php';

class CategoryController
{
    private $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new Category();
    }

    public function getAll()
    {
        return $this->categoryModel->all();
    }

    public function getById($id)
    {
        return $this->categoryModel->find($id);
    }

    public function getFilterCategories($limit, $offset, $keyword)
    {
        return $this->categoryModel->getFilteredCategories($limit, $offset, $keyword);
    }

    public function countCategories()
    {
        return $this->categoryModel->countCategory();
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
        var_dump($existingcategory);
        return [
            'success' => true,
            'message' => 'Cập nhật thể loại thành công!',
            'category' => $categoryEdit
        ];
    }

    public function delete($id)
    {
        return $this->categoryModel->updateDeleted($id);
    }
}
