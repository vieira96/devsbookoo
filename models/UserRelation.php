<?php

class UserRelation {

    public $id;
    public $user_from;
    public $user_to;
}

interface UserRelationDAO {
    public function insert(UserRelation $userRelation);
    public function getFollowing($id);
    public function getFollowers($id);
} 