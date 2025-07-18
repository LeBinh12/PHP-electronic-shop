<?php

require_once './models/Shipping.php';

class ShippingController
{
    private $shippingModel;

    public function __construct()
    {
        $this->shippingModel = new Shipping();
    }

    public function add($data)
    {
        try {
            $shipping = $this->shippingModel->insert($data);
            return [
                'success' => true,
                'message' => 'Thêm địa chỉ thành công',
                'shipping' => $shipping
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ];
        }
    }
}
