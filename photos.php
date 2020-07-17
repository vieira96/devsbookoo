<?php

require_once 'config.php';
require_once 'models/Auth.php';
require_once 'dao/PostDaoMysql.php';
require_once 'dao/UserDaoMysql.php';

$activeMenu = '';
$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRIPPED);

if(!$id){
    $id = $userInfo->id;
}

if($id == $userInfo->id) {
    $activeMenu = "photos";
}

$postDao = new PostDaoMysql($pdo);
$userDao = new UserDaoMysql($pdo);


//Pegar informações do usuario

$user = $userDao->findById($id, true);
if(!$user) { 
    header("Location: ".$base);
    exit;
}

//verificar se sigo esse usuario


require 'partials/header.php';
require 'partials/menu.php'; 
?>

<section class="feed">

<?php require 'partials/feed-header.php'; ?>

<div class="row">

    <div class="column">
                    
        <div class="box">
            <div class="box-body">

                <div class="full-user-photos">

                    <?php foreach($user->photos as $key => $photo): ?>
                        <div class="user-photo-item">
                            <a href="#modal-<?=$key;?>" rel="modal:open">
                                <img src="<?= $base; ?>/media/uploads/<?=$photo->body;?>" />
                            </a>
                            <div id="modal-<?=$key;?>" style="display:none">
                                <img src="<?= $base ?>/media/uploads/<?=$photo->body;?>" />
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php if(count($user->photos) === 0): ?>
                        <?= "Não há fotos desse usuário..." ?>
                    <?php endif; ?>
                </div>
                

            </div>
        </div>

    </div>
    
</div>

</section>

<?php require 'partials/footer.php';?>
