<?php

require_once 'config.php';
require_once 'models/Auth.php';
require_once 'models/Post.php';
require_once 'dao/PostShareDaoMysql.php';
require_once 'dao/PostDaoMysql.php';
require_once 'vendor/autoload.php';

use Intervention\Image\ImageManager;

$manager = new ImageManager();

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if($id) {
    $postDao = new PostDaoMysql($pdo);
    $postShareDao = new PostShareDaoMysql($pdo);

    $post = $postDao->findPostById($id);
    if($post) {
        $newPost = new Post();
        $newPost->id_user = $userInfo->id;
        if($post->type == 'photo') {
            $img = $manager->make('media/uploads/'.$post->body);
            $fileName = uniqid(rand(0,9999)).'.jpg';
            $img->save('./media/uploads/'.$fileName);
            $newPost->body = $fileName;
        }else {
            $newPost->body = $post->body;
        }

        if($post->type == 'text' || $post->type == 'sharedPost') {
            $newPost->type = 'sharedPost';
        } elseif($post->type == 'photo' || $post->type == 'sharedPhoto') {
            $newPost->type = 'sharedPhoto';
        }
        $newPost->created_at = date("Y-m-d H:i:s");

        $postDao->insert($newPost);
        $postShareDao->insert($post->id, $userInfo->id);
    }
}

header("Location: ".$base);
exit;