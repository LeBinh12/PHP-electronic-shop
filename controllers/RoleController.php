<?php

require_once './models/Role.php';
require_once './models/RoleMenu.php';

class RoleController
{
    private $roleModel;
    private $roleMenuModel;

    public function __construct()
    {
        $this->roleModel = new Role();
        $this->roleMenuModel = new RoleMenu();
    }

    public function getAll()
    {
        return $this->roleModel->all();
    }

    public function getById($id)
    {
        return $this->roleModel->find($id);
    }

    public function getPagination($keyword, $limit, $offset)
    {
        return $this->roleModel->getFilterRoles($keyword, $limit, $offset);
    }

    public function countRole($keyword)
    {
        return $this->roleModel->countFilteredRoles($keyword);
    }

    public function add($data)
    {
        try {
            if ($this->roleModel->existsByNameRole($data['name'])) {
                return [
                    'success' => false,
                    'message' => 'Tên quyền đã tồn tại'
                ];
            }
            $Role = $this->roleModel->insert($data);
            return [
                'success' => true,
                'message' => 'Thêm quyền thành công',
                'Role' => $Role
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function getMenuByRole($id)
    {
        return $this->roleMenuModel->getMenuIdsByRole($id);
    }

    public function getRoleWithMenu()
    {
        return $this->roleModel->getAllRolesWithMenus();
    }

    public function createRoleWithMenus($roleName, $menuIds)
    {
        if ($roleName === '' || empty($menuIds)) {
            return ['success' => false, 'message' => 'Phải nhập tên quyền và chọn ít nhất 1 chức năng'];
        }

        $roleId = $this->roleModel->insert([
            'role_name' => $roleName,
            'isDeleted' => 0
        ]);

        foreach ($menuIds as $item) {
            $this->roleMenuModel->insert([
                'menu_id' => $item,
                'role_id' => $roleId,
                'isDeleted' => 0
            ]);
        }

        return ['success' => true, 'role_id' => $roleId, 'message' => 'Thêm quyền thành công'];
    }

    public function updateRoleMenus($roleId, array $menuIds)
    {
        $this->roleMenuModel->updateByRoleId($roleId, ['isDeleted' => 1]);

        foreach ($menuIds as $mid) {
            $existing = $this->roleMenuModel->first([
                'role_id' => $roleId,
                'menu_id' => $mid
            ]);

            if ($existing) {
                $this->roleMenuModel->forceUpdate($existing['id']);
            } else {
                $this->roleMenuModel->insert([
                    'menu_id' => $mid,
                    'role_id' => $roleId,
                    'isDeleted' => 0
                ]);
            }
        }
        return ['success' => true];
    }

    public function update($id, $data)
    {
        try {

            $existingById = $this->roleModel->find($id);
            if ($existingById == null) {
                return [
                    'success' => false,
                    'message' => 'Quyền không tồn tại!'
                ];
            }

            $existingByName = $this->roleModel->existsByNameExceptIdRole($id, $data['name']);
            if ($existingByName) {
                return [
                    'success' => false,
                    'message' => 'Tên quyền này đã tồn tại, vui lòng chọn tên khác.'
                ];
            }

            $RoleEdit = $this->roleModel->update($id, $data);
            return [
                'success' => true,
                'message' => 'Cập nhật quyền thành công',
                'Role' => $RoleEdit
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function delete($id)
    {
        try {
            $delete = $this->roleModel->updateDeleted($id);
            return [
                'success' => true,
                'message' => 'Xóa quyền thành công',
                'Role' => $delete
            ];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
