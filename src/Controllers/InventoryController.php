<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\inventoryService;
use App\Config\database;

class InventoryController extends Controller
{
    public function __construct(database $db)
    {
        parent::__construct($db);
    }

    public function inventory()
    {
        $stocks = new inventoryService($this->db->getConnection());
        $this->render("inventory", ['stocks' => $stocks->fetchProducts(), 'item' => $stocks->fetchFirstProduct()]);
    }

    public function displayDetails() {
        header("Content-Type: application/json");
        $json = file_get_contents('php://input');
        $data = json_decode($json, false);
        $id = $data->id;
        $stocks = new inventoryService($this->db->getConnection());
        $result = $stocks->fetchProductDetails($id);
        echo json_encode($result);
    }


    public function removeProduct() {
        header("Content-Type: application/json");
        $json = file_get_contents('php://input');
        $data = json_decode($json, false);
        $id = $data->id;
        $stocks = new inventoryService($this->db->getConnection());
        $stocks->deleteProduct($id);
        echo json_encode(["success" => true, "message" => "Deleted Successfully"]);
    }

    public function getFirstProduct() {
        header("Content-Type: application/json");
        $stocks = new inventoryService($this->db->getConnection());
        $product = $stocks->fetchFirstProduct();
        echo json_encode(["success" => true, "product" => $product]);
    }
}
