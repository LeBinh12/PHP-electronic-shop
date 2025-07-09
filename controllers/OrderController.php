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

    public function getCountOrder(int $userId, ?int $statusId, $keyword): int
    {
        return $this->orderModel->countOrders($userId, $statusId, $keyword);
    }

    public function getAllOrdersPagination(string $keyword, int $limit, int $offset)
    {
        return $this->orderModel->findAllOrders($keyword, $limit, $offset);
    }

    public function getAllCountOrder(string $keyword)
    {
        return $this->orderModel->countAllOrders($keyword);
    }

    public function edit($id, $data)
    {
        $orderEdit = $this->orderModel->update($id, $data);
        return [
            "success" => true,
            "message" => 'Cập nhật đơn hàng thành công',
            'order' => $orderEdit
        ];
    }

    // public function getCountOrder($userId) {
    //     return $this->orderModel->getCountOrderByUserId($userId);
    // }
}
