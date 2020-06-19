<?php

require_once 'dao/PostDaoMysql.php';

class Post {

    public $id;
    public $user_id;
    public $created_at;
    public $type;
    public $body;
}

interface PostDAO {
    public function insert(Post $p);
} 