<?php

require_once 'dao/PostDaoMysql.php';

class Post {

    public $id;
    public $id_user;
    public $created_at;
    public $type;
    public $body;
}

interface PostDAO {
    public function insert(Post $p);
    public function getUserFeed($id_user, $user_online);
    public function getHomeFeed($id_user);
    public function getPhotosFrom($id_user);
} 