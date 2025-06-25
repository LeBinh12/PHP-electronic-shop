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
}
