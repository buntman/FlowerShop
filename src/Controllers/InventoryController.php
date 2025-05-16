<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\InventoryService;
use App\Config\database;

class InventoryController extends Controller
{
    private $inventory;

    public function __construct(database $db)
    {
        parent::__construct($db);
        $this->initializeInventoryService();
    }

    private function initializeInventoryService()
    {
        $this->inventory = new InventoryService($this->db->getConnection());
    }

    public function inventory()
    {
        $this->render("admin-inventory", ['stocks' => $this->inventory->getProducts(), 'initial_item' => $this->inventory->getFirstProduct(), 'total_products' => $this->inventory->getNumberOfProducts()]);
    }

    public function getProductDetails()
    {
        header("Content-Type: application/json");
        $json = file_get_contents('php://input');
        $data = json_decode($json, false);
        $id = $data->id;
        $result = $this->inventory->getProductDetails($id);
        echo json_encode($result);
    }


    public function deleteProduct()
    {
        header("Content-Type: application/json");
        $json = file_get_contents('php://input');
        $data = json_decode($json, false);
        $id = $data->id;
        $this->inventory->deleteProduct($id);
        echo json_encode(["success" => true, "message" => "Deleted Successfully"]);
    }

    public function getFirstProduct()
    {
        header("Content-Type: application/json");
        $product = $this->inventory->getFirstProduct();
        echo json_encode(["success" => true, "product" => $product]);
    }


    public function updateProductDetails()
    {
        header("Content-Type: application/json");
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $id = $data['currentProductId'];
        $name = $data['name'];
        $stock = $data['stock'];
        $description = $data['description'];
        $price = $data['price'];
        $this->inventory->updateProductDetails($id, $name, $stock, $description, $price);
        echo json_encode(["success" => true, "message" => "Updated Successfully!"]);
    }
}
