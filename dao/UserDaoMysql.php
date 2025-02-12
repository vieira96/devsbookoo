<?php

require_once 'models/User.php';
require_once 'dao/UserRelationDaoMysql.php';
require_once 'dao/PostDaoMysql.php';

class UserDaoMysql implements UserDAO {

    private $pdo;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    }

    private function generateUser($array, $full = false) {
        $u = new User();

        $u->id = $array['id'] ?? '';
        $u->name = $array['name'] ?? '';
        $u->email = $array['email'] ?? '';
        $u->password = $array['password'] ?? '';
        $u->token = $array['token'] ?? '';
        $u->avatar = $array['avatar'] ?? '';
        $u->cover = $array['cover'] ?? '';
        $u->city = $array['city'] ?? '';
        $u->work = $array['work'] ?? '';
        $u->birthdate = $array['birthdate'] ?? '';

        if($full) {
            $urDaoMysql = new UserRelationDaoMysql($this->pdo);
            $postDaoMysql = new PostDaoMysql($this->pdo);

            // followers = quem segue o usuarios
            $u->followers = $urDaoMysql->getFollowers($u->id);
            foreach($u->followers as $key => $followerId) {
                $newUser = $this->findById($followerId);
                $u->followers[$key] = $newUser;
            }

            // followings = quem o usuário segue
            $u->followings = $urDaoMysql->getfollowings($u->id);
            foreach($u->followings as $key => $followingsId) {
                $newUser = $this->findById($followingsId);
                $u->followings[$key] = $newUser;
            }

            // fotos

            $u->photos = $postDaoMysql->getPhotosFrom($u->id);
        }

        return $u;
    }

    public function findByToken($token)
    {
        if(!empty($token)){
            $sql = $this->pdo->prepare("SELECT * FROM users WHERE token = :token");
            $sql->bindValue(":token", $token);
            $sql->execute();
            
            if($sql->rowCount() > 0) {
                $data = $sql->fetch(PDO::FETCH_ASSOC);
                $user = $this->generateUser($data);

                return $user;
            }
        }

        return false;
    }

    public function findByEmail($email)
    {
        if(!empty($email)){
            $sql = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
            $sql->bindValue(":email", $email);
            $sql->execute();

            if($sql->rowCount() > 0) {
                $data = $sql->fetch(PDO::FETCH_ASSOC);
                $user = $this->generateUser($data);

                return $user;
            }
        }

        return false;
    }

    public function findByName($name) 
    {
        $array = [];

        if(!empty($name)){
            $sql = $this->pdo->prepare("SELECT id, name, avatar FROM users WHERE name LIKE :name");
            $sql->bindValue(":name", "%".$name."%");
            $sql->execute();

            if($sql->rowCount() > 0) {
                
                $data = $sql->fetchAll(PDO::FETCH_ASSOC);
                foreach($data as $user) {
                    $array[] = $this->generateUser($user);
                }
            }
        }

        return $array;
    }
    
    public function findById($id, $full = false)
    {
        if(!empty($id)){
            $sql = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
            $sql->bindValue(":id", $id);
            $sql->execute();

            if($sql->rowCount() > 0) {
                $data = $sql->fetch(PDO::FETCH_ASSOC);
                $user = $this->generateUser($data, $full);

                return $user;
            }
            
        }


        return false;
    }

    public function update(User $u)
    {
        $sql = $this->pdo->prepare("UPDATE users SET
            email = :email,
            password = :password,
            name = :name,
            birthdate = :birthdate,
            city = :city,
            work = :work,
            avatar = :avatar,
            cover = :cover,
            token = :token,
            id = :id 
        WHERE id = :id");

        $sql->bindValue(":email", $u->email);
        $sql->bindValue(":password", $u->password);
        $sql->bindValue(":name", $u->name);
        $sql->bindValue(":birthdate", $u->birthdate);
        $sql->bindValue(":city", $u->city);
        $sql->bindValue(":work", $u->work);
        $sql->bindValue(":avatar", $u->avatar);
        $sql->bindValue(":cover", $u->cover);
        $sql->bindValue(":token", $u->token);
        $sql->bindValue(":id", $u->id);
        
        $sql->execute();

        return true;
    }

    public function insert(User $u)
    {
        $sql = $this->pdo->prepare("INSERT INTO users (name, email, password, birthdate, token) VALUES (:name, :email, :password, :birthdate, :token)");
        $sql->bindValue(":name", $u->name);
        $sql->bindValue(":email", $u->email);
        $sql->bindValue(":password", $u->password);
        $sql->bindValue(":birthdate", $u->birthdate);
        $sql->bindValue(":token", $u->token);
        $sql->execute();

        return true;
    }
}