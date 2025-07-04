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


    public function getOrderPagination(int $userId, ?int $statusId, int $limit, int $offset)
    {
        return $this->orderModel->findOrders($userId, $statusId, $limit, $offset);
    }

    public function getCountOrder(int $userId, ?int $statusId): int
    {
        return $this->orderModel->countOrders($userId, $statusId);
    }

    public function getAllOrdersPagination(string $keyword, int $limit, int $offset)
    {
        return $this->orderModel->findAllOrders($keyword, $limit, $offset);
    }

    public function getAllCountOrder(string $keyword)
    {
        return $this->orderModel->countAllOrders($keyword);
    }

    // public function getCountOrder($userId) {
    //     return $this->orderModel->getCountOrderByUserId($userId);
    // }
}
