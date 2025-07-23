<?php

require_once './models/Employee.php';
require_once './models/EmployeeMenu.php';
require_once './models/RoleEmployee.php';


class EmployeeController
{
    private $employeeModel;
    private $employeeMenuModel;
    private $roleEmployeeModel;

    public function __construct()
    {
        $this->employeeModel = new Employee();
        $this->employeeMenuModel = new EmployeeMenu();
        $this->roleEmployeeModel = new RoleEmployee();
    }

    public function getAll()
    {
        return $this->employeeModel->all();
    }

    public function getById($id)
    {
        return $this->employeeModel->find($id);
    }

    public function getMenuByUserId($id)
    {
        return $this->employeeMenuModel->getByEmployeeId($id);
    }

    public function getRoleIds($employeeId)
    {
        $roles = $this->roleEmployeeModel->getByEmployeeId($employeeId);
        return array_column($roles, 'role_id');
    }

    public function getMenuIds($employeeId)
    {
        $menus = $this->employeeMenuModel->getIdByEmployeeId($employeeId);
        return array_column($menus, 'menu_id');
    }


    public function getPagination($keyword, $limit, $offset)
    {
        return $this->employeeModel->getFilterEmployees($keyword, $limit, $offset);
    }

    public function countEmployees($keyword)
    {
        return $this->employeeModel->countFilteredEmployees($keyword);
    }

    public function add($data, $roleIds = [], $menuIds = [])
    {
        try {
            if ($this->employeeModel->existsByName($data['name'])) {
                return [
                    'success' => false,
                    'message' => 'Tên nhân viên đã tồn tại!'
                ];
            }
            $employeeId = $this->employeeModel->insert($data);
            foreach ($roleIds as $rid) {
                $this->roleEmployeeModel->insert([
                    'employee_id' => $employeeId,
                    'role_id' => $rid,
                    'isDeleted' => 0
                ]);
            }

            foreach ($menuIds as $mid) {
                $this->employeeMenuModel->insert([
                    'employee_id' => $employeeId,
                    'menu_id' => $mid,
                    'isDeleted' => 0
                ]);
            }

            return ['success' => true];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function update($id, $data, $roleIds = [], $menuIds = [])
    {
        try {

            $existingById = $this->employeeModel->find($id);
            if ($existingById == null) {
                return [
                    'success' => false,
                    'message' => 'Nhân viên không tồn tại!'
                ];
            }

            $existingByName = $this->employeeModel->existsByNameExceptId($id, $data['name']);
            if ($existingByName) {
                return [
                    'success' => false,
                    'message' => 'Tên nhân viên này đã tồn tại, vui lòng chọn tên khác.'
                ];
            }

            $this->employeeModel->update($id, $data);

            $this->roleEmployeeModel->deleteByEmployee(employeeId: $id);
            foreach ($roleIds as $rid) {
                $this->roleEmployeeModel->insert([
                    'employee_id' => $id,
                    'role_id' => $rid,
                    'isDeleted' => 0
                ]);
            }

            $this->employeeMenuModel->deleteByEmployee($id);
            foreach ($menuIds as $mid) {
                $this->employeeMenuModel->insert([
                    'employee_id' => $id,
                    'menu_id' => $mid,
                    'isDeleted' => 0
                ]);
            }

            return ['success' => true, 'message' => 'Cập nhật nhân viên thành công!'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function delete($id)
    {
        $existingById = $this->employeeModel->find($id);
        if ($existingById == null) {
            return [
                'success' => false,
                'message' => 'Nhân viên không tồn tại!'
            ];
        }
        $this->employeeModel->updateDeleted($id);
        $this->roleEmployeeModel->deleteByEmployee(employeeId: $id);
        $this->employeeMenuModel->deleteByEmployee($id);

        return ['success' => true];
    }
}
