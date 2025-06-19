<?php

require_once './models/Inventory.php';

class InventoryController
{
    private $InventoryController;

    public function __construct()
    {
        $this->InventoryController = new Inventory();
    }

    public function getAll()
    {
        return $this->InventoryController->all();
    }

    public function getById($id)
    {
        return $this->InventoryController->find($id);
    }

    public function add($data)
    {
        $supplier = $this->InventoryController->insert($data);
        return [
            'success' => true,
            'message' => 'Thêm kho hàng thành công',
            'supplier' => $supplier
        ];
    }

    public function edit($id, $data)
    {
        $supplierEdit = $this->InventoryController->update($id, $data);
        return [
            'success' => true,
            'message' => 'Cập nhật kho hàng thành công!',
            'supplier' => $supplierEdit
        ];
    }

    public function delete($id)
    {
        return $this->InventoryController->updateDeleted($id);
    }
}
