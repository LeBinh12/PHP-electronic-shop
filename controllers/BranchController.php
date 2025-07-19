<?php

require_once './models/Branch.php';

class BranchController
{
    private $branchController;
    public function __construct()
    {
        $this->branchController = new Branch();
    }

    public function getAll()
    {
        return $this->branchController->all();
    }

    public function getById($id)
    {
        return $this->branchController->find($id);
    }

    public function getPagination($limit, $offset, $keyword)
    {
        return $this->branchController->getFilteredBranch($limit, $offset, $keyword);
    }

    public function countBranch($keyword)
    {
        return $this->branchController->countCategory($keyword);
    }

    public function add($data)
    {
        try {
            $existingBranch = $this->branchController->existsByName($data['name']);
            if ($existingBranch) {
                return [
                    'success' => false,
                    'message' => 'Chi nhánh này đã tồn tại!'
                ];
            }
            $branch = $this->branchController->insert($data);
            return [
                'success' => true,
                'message' => 'Thêm dữ liệu thành công',
                'branch' => $branch
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Lỗi ' . $e->getMessage()
            ];
        }
    }

    public function update($id, $data)
    {
        try {
            $existingById = $this->branchController->find($id);
            if ($existingById == null) {
                return [
                    'success' => false,
                    'message' => 'Chi nhánh này không tồn tại, vui lòng chọn tên khác.'
                ];
            }
            $existingBranch = $this->branchController->existsByNameExceptId($id, $data['name']);

            if ($existingBranch) {
                return [
                    'success' => false,
                    'message' => 'Tên chi nhánh đã tồn tại, vui lòng chọn tên khác.'
                ];
            }
            $editBranch = $this->branchController->update($id, $data);
            return [
                'success' => true,
                'message' => 'Cập nhật dữ liệu thành công',
                'branch' => $editBranch
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Lỗi ' . $e->getMessage()
            ];
        }
    }

    public function delete($id)
    {
        try {
            $existingById = $this->branchController->find($id);
            if ($existingById == null) {
                return [
                    'success' => false,
                    'message' => 'Chi nhánh này không tồn tại, vui lòng chọn tên khác.'
                ];
            }
            $editBranch = $this->branchController->updateDeleted($id);
            return [
                'success' => true,
                'message' => 'Xóa dữ liệu thành công',
                'branch' => $editBranch
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Lỗi ' . $e->getMessage()
            ];
        }
    }
}
