<?php

namespace App\Models;

class UserService
{
    private $connect;
    private $errors = [];

    public function __construct($connection)
    {
        $this->connect = $connection;
    }

    public function save($clean_form)
    {
        $email = $clean_form['email'];
        $password = $clean_form['password'];
        $encrypted_pass = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users(email, password) VALUES(?,?)";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement, 'ss', $email, $encrypted_pass);
        mysqli_stmt_execute($sql_statement);
    }

    public function findUserByEmail($email)
    {
        $sql = "SELECT * FROM users where email = ?";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement, 's', $email);
        mysqli_stmt_execute($sql_statement);
        $result = mysqli_stmt_get_result($sql_statement);
        $user = mysqli_fetch_assoc($result);
        return $user;
    }

    public function getUserDetails($user_id)
    {
        $sql = "SELECT * FROM users where id = ?";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement, 'i', $user_id);
        mysqli_stmt_execute($sql_statement);
        $result = mysqli_stmt_get_result($sql_statement);
        $user = mysqli_fetch_assoc($result);
        return $user;
    }

    public function editProfile($user_details, $user_id)
    {
        $sql = "UPDATE users SET name = ?, contact_number = ? where id = ?";
        $sql_statement = mysqli_prepare($this->connect, $sql);
        mysqli_stmt_bind_param($sql_statement, 'ssi', $user_details->name, $user_details->contact_number, $user_id);
        mysqli_stmt_execute($sql_statement);
    }
}
