<?php

namespace App\Models;

use Hashids\Hashids;

class OrderService
{
    private $connect;
    private $hash_id;

    public function __construct($connection)
    {
        $this->connect = $connection;
        $this->hash_id = new Hashids('', 5);
    }

    public function fetchItemsToCheckOut($user_id)
    {
        $sql = "SELECT p.name AS product_name,
        c.quantity,
        c.price * c.quantity AS subprice
        FROM cart c
        INNER JOIN
        products p ON c.product_id = p.id
        WHERE c.status = 'active' and c.user_id = ?";
        $stmt = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $rows;
    }

    public function addOrderDetails($order_details, $user_id)
    {
        $sql = "INSERT INTO orders(user_id, payment_method, total_price, pickup_date, pickup_time) VALUES(?,?,?,?,?)";
        $stmt = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($stmt, 'isdss', $user_id, $order_details->payment_method, $order_details->total_price, $order_details->pickup_date, $order_details->pickup_time);
        mysqli_stmt_execute($stmt);
        return mysqli_insert_id($this->connect);
    }

    public function addOrderItems($order_id, $product_id, $quantity)
    {
        $sql = "INSERT INTO order_items(order_id, product_id, quantity) VALUES(?,?,?)";
        $stmt = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($stmt, 'iii', $order_id, $product_id, $quantity);
        mysqli_stmt_execute($stmt);
    }

    public function updatePendingOrderStatus($id)
    {
        $sql = "UPDATE order_items SET status = 'Completed' where id = ?";
        $stmt = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $order_id = $this->findOrderId($id);
        $this->updateCompleteOrderStatus($order_id);
    }

    public function updateCompleteOrderStatus($id)
    {
        $sql = "SELECT COUNT(*) AS count FROM order_items where order_id = ? and status = 'Pending'";
        $stmt = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        if ($row['count'] == 0) {
            $sql = "UPDATE orders SET status = 'Ready for Pickup' where id = ?";
            $stmt = mysqli_prepare($this->connect, $sql);
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
        }
    }

    public function fetchPendingOrders()
    {
        $sql = "SELECT p.name AS product_name,
        p.image_path AS product_image,
        u.name AS customer_name,
        o.id,
        o.pickup_date,
        o.pickup_time,
        oi.id AS item_id,
        oi.quantity
        FROM order_items oi
        JOIN products p ON oi.product_id = p.id
        JOIN orders o ON oi.order_id = o.id
        JOIN users u ON o.user_id = u.id
        WHERE oi.status = 'Pending'";
        $stmt = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($rows as &$row) {
            $row['id'] = $this->hash_id->encode($row['id']);
        }
        unset($row);
        return $rows;
    }

    public function fetchCompleteOrders()
    {
        $sql = "SELECT p.name AS product_name,
        p.image_path AS product_image,
        u.name AS customer_name,
        o.id,
        o.pickup_date,
        o.pickup_time,
        o.status,
        oi.id AS item_id,
        oi.quantity
        FROM order_items oi
        JOIN products p ON oi.product_id = p.id
        JOIN orders o ON oi.order_id = o.id
        JOIN users u ON o.user_id = u.id
        WHERE oi.status = 'Completed'
        ORDER BY case o.status
        WHEN 'Pending' THEN 1
        WHEN 'Ready for Pickup' THEN 2
        WHEN 'Picked Up' THEN 3
        END
        ";
        $stmt = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($rows as &$row) {
            $row['id'] = $this->hash_id->encode($row['id']);
        }
        unset($row);
        return $rows;
    }

    public function findOrderId($item_id)
    {
        $sql = "SELECT order_id FROM order_items where id = ?";
        $stmt = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $item_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        return $row['order_id'];
    }


    public function fetchOrderDetailsOfUser($user_id)
    {
        $sql = "SELECT * FROM orders where user_id = ?";
        $stmt = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($orders as &$order) {
            $order['items'] = $this->fetchAllItemsInOrder($order['id']); //attach the specific items in the order
            $order['id'] = $this->hash_id->encode($order['id']);
        }
        unset($order);
        return $orders;
    }

    public function fetchAllItemsInOrder($order_id)
    {
        $sql = "SELECT p.name as product_name,
        oi.quantity,
        p.price * oi.quantity as price
        FROM order_items oi
        JOIN products p ON oi.product_id = p.id
        WHERE oi.order_id = ?";
        $stmt = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $order_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $rows;
    }

    public function updatePickedUpOrderStatus($order_id)
    {
        $decode_data = $this->hash_id->decode($order_id);
        $id = $decode_data[0];
        $sql = "UPDATE orders set status = 'Picked Up' where id = ?";
        $stmt = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $this->insertOrderDetailsInReport($id);
    }

    public function insertOrderDetailsInReport($order_id)
    {
        $sql = "INSERT INTO reports(order_id, customer_name, contact_number, total_price)
        SELECT o.id, u.name as customer_name, u.contact_number, o.total_price
        FROM orders o
        JOIN users u ON o.user_id = u.id
        WHERE o.id = ? ";
        $stmt = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $order_id);
        mysqli_stmt_execute($stmt);
    }
}
