<?php

require_once 'dao/UserDaoMysql.php';

class User {

    public $id;
    public $email;
    public $password;
    public $name;
    public $birthdate;
    public $work;
    public $city;
    public $avatar;
    public $cover;
    public $token;
}

interface UserDAO {
    public function findByToken($token);
    public function findByEmail($email);
    public function findByName($name);
    public function findById($id);
    public function update(User $u);
    public function insert(User $u);
} 