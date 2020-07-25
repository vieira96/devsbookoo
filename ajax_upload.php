<?php
require_once 'config.php';
require_once 'models/Auth.php';
require_once 'dao/PostDaoMysql.php';
require_once 'vendor/autoload.php';

use Intervention\Image\ImageManager;

$manager = new ImageManager();

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

$array = ['error' => ''];

$postDao = new PostDaoMysql($pdo);
if(isset($_FILES['photo']) && !empty($_FILES['photo']['tmp_name'])) {
    $photo = $_FILES['photo'];
    $allowedFiles = ['image/jpeg', 'image/jpg', 'image/png'];

    if(in_array($photo['type'], $allowedFiles)) {
        
        $fileName = $userInfo->id . md5(uniqid(rand(0, 9999))) . ".jpg";

        $img = $manager->make($photo['tmp_name']);
        $img->resize(800, 600, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $img->save('./media/uploads/'.$fileName);

        $newPost = new Post();
        $newPost->id_user = $userInfo->id;
        $newPost->type = 'photo';
        $newPost->created_at = date('Y-m-d H:i:s');
        $newPost->body = $fileName;

        $postDao->insert($newPost);

    } else {
        $array['error'] = 'Arquivo Inválido';
    }

} else {
    $array['error'] = 'Nenhuma imagem enviada';
}

header("Content-Type: application/json");
echo json_encode($array);
exit;