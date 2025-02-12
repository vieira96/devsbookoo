<?php


require_once 'config.php';
require_once 'models/Auth.php';
require_once 'models/PostComment.php';
require_once 'dao/PostCommentDaoMysql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

$id = filter_input(INPUT_POST, 'id');
$txt = filter_input(INPUT_POST, 'txt');
$array = [];

if($id && $txt) {
    $postCommentDaoMysql = new PostCommentDaoMysql($pdo);
    $newComment = new PostComment();
    $newComment->id_post = $id;
    $newComment->id_user = $userInfo->id;
    $newComment->body = $txt;

    $postCommentDaoMysql->addComment($newComment);

    $array = [
        'error' => '',
        'link' => $base.'profile.php?id='.$newComment->id_user,
        'avatar' => $base.'/media/avatars/'.$userInfo->avatar,
        'name' => $userInfo->name,
        'body' => $txt
    ];
    
}

header("Content-Type: application/json");
echo json_encode($array);
exit;