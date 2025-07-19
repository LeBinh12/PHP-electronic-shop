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
        try {
            if ($this->menuModel->existsByNameMenu($data['name'])) {
                return [
                    'success' => false,
                    'message' => 'Tên chức năng đã tồn tại!'
                ];
            }
            $menu = $this->menuModel->insert($data);
            return [
                'success' => true,
                'message' => 'Thêm chức năng thành công',
                'menu' => $menu
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function update($id, $data)
    {
        try {
            $existingById = $this->menuModel->find($id);
            if ($existingById == null) {
                return [
                    'success' => false,
                    'message' => 'Chức năng không tồn tại!'
                ];
            }

            $existingByName = $this->menuModel->existsByNameExceptIdMenu($id, $data['name']);
            if ($existingByName) {
                return [
                    'success' => false,
                    'message' => 'Tên chức năng này đã tồn tại, vui lòng chọn tên khác.'
                ];
            }

            $menuEdit = $this->menuModel->update($id, $data);
            return [
                'success' => true,
                'message' => 'Cập chức năng thành công',
                'menu' => $menuEdit
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function delete($id)
    {
        try {
            $existingById = $this->menuModel->find($id);
            if ($existingById == null) {
                return [
                    'success' => false,
                    'message' => 'Chức năng không tồn tại!'
                ];
            }
            $delete = $this->menuModel->updateDeleted($id);
            return [
                'success' => true,
                'message' => 'Xóa chức năng thành công',
                'menu' => $delete
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
