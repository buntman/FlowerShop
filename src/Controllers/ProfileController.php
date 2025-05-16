<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Config\database;
use App\Config\JwtConfig;
use App\Models\UserService;

class ProfileController extends Controller
{
    public function __construct(database $db)
    {
        parent::__construct($db);
    }

    public function getUserDetails()
    {
        header("Content-Type: application/json");
        $user_id = JwtConfig::getInstance()->getUserId();
        $user_service = new UserService($this->db->getConnection());
        $user_details = $user_service->getUserDetails($user_id);
        echo json_encode($user_details);
    }

    public function editProfile()
    {
        header("Content-Type: application/json");
        $json = file_get_contents('php://input');
        $user_details = json_decode($json, false);
        $user_id = JwtConfig::getInstance()->getUserId();
        $user_service = new UserService($this->db->getConnection());
        $user_service->editProfile($user_details, $user_id);
    }
}
