<?php
require_once './models/Product.php';


class ProductController
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    public function getAll()
    {
        return $this->productModel->all();
    }

    public function getById($id)
    {
        return $this->productModel->find($id);
    }

    public function getProductByCategory($id)
    {
        return $this->productModel->getProductsByCategory($id);
    }

    public function add($data)
    {
        if ($this->productModel->existsByName($data['name'])) {
            return [
                'success' => false,
                'message' => 'Tên sản phẩm đã tồn tại!'
            ];
        }
        $product = $this->productModel->insert($data);
        return [
            'success' => true,
            'message' => 'Thêm sản phẩm thành công',
            'product' => $product
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
        return [
            'success' => true,
            'message' => 'Cập nhật sản phẩm thành công!',
            'product' => $productEdit
        ];
    }

    public function delete($id)
    {
        return $this->productModel->updateDeleted($id);
    }
}
