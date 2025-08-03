<?php

require_once './models/Employee.php';
require_once './models/EmployeeMenu.php';
require_once './models/RoleEmployee.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class EmployeeController
{
    private $employeeModel;
    private $employeeMenuModel;
    private $roleEmployeeModel;
    private $jwtConfig;


    public function __construct()
    {
        $this->employeeModel = new Employee();
        $this->employeeMenuModel = new EmployeeMenu();
        $this->roleEmployeeModel = new RoleEmployee();
        $this->jwtConfig = include   './config/jwt.php';
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

            $data['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
            unset($data['password']);

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

            return ['success' => true, 'message' => 'Tạo nhân viên mới thành công'];
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

    public function refreshtoken($id)
    {

        $updatedEmployee = $this->employeeModel->find($id);

        // Tạo lại token
        $now = time();
        $token = [
            'iss' => $this->jwtConfig['issuer'],
            'aud' => $this->jwtConfig['audience'],
            'iat' => $now,
            'nbf' => $now,
            'exp' => $now + 3600,
            'data' => [
                'id' => $updatedEmployee['id'],
                'email' => $updatedEmployee['email'],
                'name' => $updatedEmployee['name'],
                'phone' => $updatedEmployee['phone'],
                'address' => $updatedEmployee['address'],
                'position' => $updatedEmployee['position'],
                'create_at' => $updatedEmployee['created_at']
            ]
        ];

        $jwt = JWT::encode($token, $this->jwtConfig['secret_key'], 'HS256');
        $_SESSION['jwt_employee'] = $jwt;
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

    public function login($data)
    {
        $employee = $this->employeeModel->findByEmail($data['email']);

        if (!$employee || !password_verify($data['password'], $employee['password_hash'])) {
            return ['success' => false, 'message' => 'Email hoặc mật khẩu không đúng'];
        }

        $now = time();
        $token = [
            'iss' => $this->jwtConfig['issuer'],
            'aud' => $this->jwtConfig['audience'],
            'iat' => $now,
            'nbf' => $now,
            'exp' => $now + 3600,
            'data' => [
                'id' => $employee['id'],
                'email' => $employee['email'],
                'name' => $employee['name'],
                'phone' => $employee['phone'],
                'address' => $employee['address'],
                'position' => $employee['position'],
                'branch_id' => $employee['branch_id'],
                'create_at' => $employee['created_at']
            ]
        ];
        $jwt = JWT::encode($token, $this->jwtConfig['secret_key'], 'HS256');
        return ['success' => true, 'token' => $jwt];
    }

    public function ChangeToPassword($email, $passwordOld, $passwordNew)
    {
        $existing = $this->employeeModel->findByEmail($email);

        if (!$existing) {
            return [
                'success' => false,
                'message' => 'Tài khoản không tồn tại!'
            ];
        }

        if (!password_verify($passwordOld, $existing['password_hash'])) {
            return [
                'success' => false,
                'message' => 'Mật khẩu cũ không đúng!'
            ];
        }

        $newHashedPassword = password_hash($passwordNew, PASSWORD_DEFAULT);

        $updateData = ['password_hash' => $newHashedPassword];
        $this->employeeModel->update($existing['id'], $updateData);

        return [
            'success' => true,
            'message' => 'Đổi mật khẩu thành công!'
        ];
    }


    public function getCurrentEmployee()
    {
        if (!isset($_SESSION['jwt_employee'])) {
            return null;
        }
        try {
            $decoded = JWT::decode($_SESSION['jwt_employee'], new Key($this->jwtConfig['secret_key'], 'HS256'));
            return $decoded->data;
        } catch (Exception $e) {
            return null;
        }
    }
}
