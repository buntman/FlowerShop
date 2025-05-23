<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Validations\FormValidator;
use App\Validations\InputSanitizer;
use App\Models\UserService;
use App\Models\Authenticate;
use App\Config\JwtConfig;
use App\Config\database;

class UserLoginController extends Controller
{
    public function __construct(database $db)
    {
        parent::__construct($db);
    }

    public function userLogin()
    {
        header("Content-Type: application/json");
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $input = new InputSanitizer($data);
        $clean_form = $input->sanitize();
        $validate_user = new FormValidator($clean_form);

        if (!$validate_user->validateUserLogin()) {
            echo json_encode(["success" => false, "errors" => $validate_user->getErrors()]);
            return;
        }

        $authenticate_user = new Authenticate($clean_form, $this->db->getConnection());

        if (!$authenticate_user->authenticateUserLogin()) {
            echo json_encode(["success" => false, "errors" => $authenticate_user->getErrors()]);
            return;
        }

        $user_service = new UserService($this->db->getConnection());
        $user = $user_service->findUserByEmail($clean_form['email']);

        $jwt = JwtConfig::getInstance()->encode($user['id']); //give token
        echo json_encode(["success" => true, 'token' => $jwt]);
    }
}
