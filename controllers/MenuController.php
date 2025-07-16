<?php

require_once './models/Menu.php';

class MenuController
{
    private $menuModel;

    public function __construct()
    {
        $this->menuModel = new Menu();
    }

    public function getAll()
    {
        return $this->menuModel->all();
    }

    public function getById($id)
    {
        return $this->menuModel->find($id);
    }

    public function getPagination($keyword, $limit, $offset)
    {
        return $this->menuModel->getFilterMenus($keyword, $limit, $offset);
    }

    public function countMenu($keyword)
    {
        return $this->menuModel->countFilteredMenus($keyword);
    }

    public function add($data)
    {
        $menu = $this->menuModel->insert($data);
        return [
            'success' => true,
            'message' => 'Thêm chức năng thành công',
            'menu' => $menu
        ];
    }

    public function update($id, $data)
    {
        $menuEdit = $this->menuModel->update($id, $data);
        return [
            'success' => true,
            'message' => 'Cập chức năng thành công',
            'menu' => $menuEdit
        ];
    }

    public function delete($id)
    {
        $delete = $this->menuModel->updateDeleted($id);
        return [
            'success' => true,
            'message' => 'Xóa chức năng thành công',
            'menu' => $delete
        ];
    }
}
