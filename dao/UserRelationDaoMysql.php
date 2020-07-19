<?php

require_once 'models/UserRelation.php';


class UserRelationDaoMysql implements UserRelationDAO {

    private $pdo;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    }

    public function insert(UserRelation $userRelation)
    {

    }

    public function followToggle(UserRelation $userRelation)
    {
        $me = $userRelation->user_from;
        $other = $userRelation->user_to;

        if($this->isFollowing($me, $other)) {
            $sql = $this->pdo->prepare("DELETE FROM userrelations WHERE user_from = :user_from AND user_to = :user_to");
        } else {
            $sql = $this->pdo->prepare("INSERT INTO userrelations (user_from, user_to) VALUES (:user_from, :user_to)");
        }
        
        $sql->bindValue(":user_from", $me);
        $sql->bindValue(":user_to", $other);
        $sql->execute();

    }

    public function isFollowing($me, $other)
    {
        $sql = $this->pdo->prepare("SELECT * FROM userrelations WHERE user_from = :user_from AND user_to = :user_to");
        $sql->bindValue(":user_from", $me);
        $sql->bindValue(":user_to", $other);
        $sql->execute();

        if($sql->rowCount() > 0) {
            return true;
        }else {
            return false;
        }
    }

    public function getfollowings($id)
    {
        $users = [];
        
        $sql = $this->pdo->prepare("SELECT user_to FROM userrelations WHERE user_from = :user_from");
        $sql->bindValue(":user_from", $id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
            foreach($data as $item) {
                $users[] = $item['user_to'];
            }
        }
        return $users;
    }

    public function getFollowers($id)
    {
        $users = [];

        $sql = $this->pdo->prepare("SELECT user_from FROM userrelations WHERE user_to = :user_to");
        $sql->bindValue(":user_to", $id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
            foreach($data as $item) {
                $users[] = $item['user_from'];
            }
        }
        return $users;
    }

}