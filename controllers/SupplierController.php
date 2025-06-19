<?php

require_once './models/Supplier.php';

class SupplierController
{
    private $supplierModel;

    public function __construct()
    {
        $this->supplierModel = new Supplier();
    }

    public function getAll()
    {
        return $this->supplierModel->all();
    }

    public function getById($id)
    {
        return $this->supplierModel->find($id);
    }

    public function add($data)
    {
        if ($this->supplierModel->existsByName($data['name'])) {
            return [
                'success' => false,
                'message' => 'Tên nhà cung cấp đã tồn tại!'
            ];
        }
        $supplier = $this->supplierModel->insert($data);
        return [
            'success' => true,
            'message' => 'Thêm nhà cung cấp thành công',
            'supplier' => $supplier
        ];
    }

    public function edit($id, $data)
    {
        $existingSupplier = $this->supplierModel->find($id);
        if ($existingSupplier == null) {
            return [
                'success' => false,
                'message' => 'nhà cung cấp không tồn tại!'
            ];
        }

        if ($data['name'] != $existingSupplier['name']) {
            if ($this->supplierModel->existsByName($data['name'])) {
                return [
                    'success' => false,
                    'message' => 'Tên nhà cung cấp đã tồn tại!'
                ];
            }
        }
        $supplierEdit = $this->supplierModel->update($id, $data);
        return [
            'success' => true,
            'message' => 'Cập nhật nhà cung cấp thành công!',
            'supplier' => $supplierEdit
        ];
    }

    public function delete($id)
    {
        return $this->supplierModel->updateDeleted($id);
    }
}
