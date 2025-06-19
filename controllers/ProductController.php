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
}
