<?php

namespace App\Models;


class inventoryService
{
    private $connect;

    public function __construct($connection)
    {
        $this->connect = $connection;
    }

    public function fetchProducts()
    {
        $admin_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM products where admin_id = ?";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement, 'i', $admin_id);
        mysqli_stmt_execute($sql_statement);
        $result = mysqli_stmt_get_result($sql_statement);
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $rows;
    }

    public function fetchProductDetails($product_name)
    {
        $sql = "SELECT * FROM products where name = ?";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement, 's', $product_name);
        mysqli_stmt_execute($sql_statement);
        $result = mysqli_stmt_get_result($sql_statement);
        $product = mysqli_fetch_assoc($result);
        return $product;
    }
}
