<?php

class UserRelation {

    public $id;
    public $user_from;
    public $user_to;
}

interface UserRelationDAO {
    public function insert(UserRelation $userRelation);
    public function getfollowings($id);
    public function getFollowers($id);
    public function isFollowing($me, $other);
    public function followToggle(UserRelation $userRelation);
} 