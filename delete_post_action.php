<?php
require_once 'config.php';
require_once 'models/Auth.php';
require_once 'dao/PostDaoMysql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);


if($id) {
    $postDao =  new PostDaoMysql($pdo);
    $post = $postDao->findPostById($id);
    if($postDao->delete($id, $userInfo->id)) {
        if($post->type == 'photo') {
            unlink('./media/uploads/'.$post->body);
        }
        sleep('1,8');
    }
}
header("Location: " . $base);
exit;