<?php

class PostShare {

    public $id;
    public $id_post;
    public $id_user;
}

interface PostShareDAO {
    public function insert(Post $p);
    public function delete($id_post, $id_user);
    public function getUserFeed($id_user, $user_online);
    public function getHomeFeed($id_user);
    public function getPhotosFrom($id_user);
    public function findPostById($id);
}