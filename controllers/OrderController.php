<?php

require_once './models/Order.php';
class OrderController
{
    private $orderModel;

    public function __construct()
    {
        $this->orderModel = new Order();
    }

    public function add($data)
    {
        $order = $this->orderModel->insert($data);
        return [
            'success' => true,
            'message' => 'Thêm đơn hàng thành công',
            'order_id' => $order
        ];
    }

    public function getById($id)
    {
        return $this->orderModel->find($id);
    }

    public function getByCode($code)
    {
        return $this->orderModel->findByCode($code);
    }

    public function getOrderPagination(int $userId, ?int $statusId, int $limit, int $offset, $keyword)
    {
        return $this->orderModel->findOrders($userId, $statusId, $keyword, $limit, $offset);
    }

    public function getOrderWithStatusPagination(?int $statusId, int $limit, int $offset, string $keyword, $branch_id = null, ?int $employeeId = null, bool $isAdmin = false)
    {
        return $this->orderModel->findOrderWithStatus($statusId, $keyword, $limit, $offset, $branch_id, $employeeId, $isAdmin);
    }

    public function getCountOrder(int $userId, ?int $statusId, $keyword): int
    {
        return $this->orderModel->countOrders($userId, $statusId, $keyword);
    }

    public function getCountOrderWithStatus(?int $statusId, string $keyword, $branch_id = null, ?int $employeeId = null, bool $isAdmin = false): int
    {
        return $this->orderModel->countOrderWithStatus($statusId, $keyword, $branch_id,  $employeeId, $isAdmin);
    }

    public function getAllOrdersPagination(string $keyword, int $limit, int $offset)
    {
        return $this->orderModel->findAllOrders($keyword, $limit, $offset);
    }


    public function getAllCountOrder(string $keyword)
    {
        return $this->orderModel->countAllOrders($keyword);
    }

    public function getUserAddressByShippingId($shippingId)
    {
        return $this->orderModel->getUserAddressByShippingId($shippingId);
    }

    public function edit($id, $data)
    {
        try {
            $orderEdit = $this->orderModel->update($id, $data);
            return [
                "success" => true,
                "message" => 'Cập nhật đơn hàng thành công',
                'order' => $orderEdit
            ];
        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => 'Lỗi" ' . $e->getMessage(),
            ];
        }
    }

    public function delete($id)
    {
        $orderDelete = $this->orderModel->updateDeleted($id);
        return [
            "success" => true,
            "message" => 'Xóa đơn hàng thành công',
        ];
    }

    // public function getCountOrder($userId) {
    //     return $this->orderModel->getCountOrderByUserId($userId);
    // }
}
