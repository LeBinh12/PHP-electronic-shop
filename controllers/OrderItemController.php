<?php

require_once './models/OrderItem.php';
class OrderItemController
{
    private $orderItemModel;

    public function __construct()
    {
        $this->orderItemModel = new OrderItem();
    }

    public function add($data)
    {
        $orderItem = $this->orderItemModel->insert($data);
        return [
            'success' => true,
            'message' => 'Thêm chi tiết đơn hàng thành công',
            'category' => $orderItem
        ];
    }

    public function countProductThisWeek()
    {
        return $this->orderItemModel->countProductsSoldThisWeek();
    }

    public function getOrderItemById($orderId)
    {
        return $this->orderItemModel->getOrderItemByOrderId($orderId);
    }

    public function canDeleteCategory($category_id)
    {
        $sql = "
        SELECT COUNT(*) as cnt
        FROM order_details od
        INNER JOIN products p ON od.product_id = p.id
        INNER JOIN orders o ON od.order_id = o.id
        WHERE p.category_id = :category_id
          AND o.status_id NOT IN (5, 6)
          AND o.isDeleted = 0
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['category_id' => $category_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Nếu cnt = 0 => không còn sản phẩm nào đang ở trạng thái chưa hoàn thành
        return $row['cnt'] == 0;
    }
}
