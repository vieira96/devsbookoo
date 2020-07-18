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
    $activeMenu = "profile";
}

$postDao = new PostDaoMysql($pdo);
$userDao = new UserDaoMysql($pdo);


//Pegar informações do usuario

$user = $userDao->findById($id, true);
if(!$user) { 
    header("Location: ".$base);
    exit;
}

$dateFrom = new DateTime($user->birthdate);
$dateTo = new DateTime('today');
$user->ageYears = $dateFrom->diff($dateTo)->y; // pega a diferença entre os anos para calcular a idade

//pegar feed do usuario

$feed = $postDao->getUserFeed($id);

//verificar se sigo esse usuario


require 'partials/header.php';
require 'partials/menu.php'; 
?>

<section class="feed">

<?php require 'partials/feed-header.php'; ?>

<div class="row">

    <div class="column side pr-5">
        
        <div class="box">
            <div class="box-body">
                
                <div class="user-info-mini">
                    <img src="<?=$base?>/assets/images/calendar.png" />
                    <?= date('d/m/Y', strtotime($user->birthdate));?> (<?=$user->ageYears;?> anos)
                </div>
                
                <?php if(!empty($user->city)): ?>
                    <div class="user-info-mini">
                        <img src="<?=$base;?>/assets/images/pin.png" />
                        <?=$user->city;?>
                    </div>
                <?php endif; ?>

                <?php if(!empty($user->work)): ?>
                    <div class="user-info-mini">
                        <img src="<?=$base?>/assets/images/work.png" />
                        <?=$user->work;?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="box">
            <div class="box-header m-10">
                <div class="box-header-text">
                    Seguindo
                    <span>(<?=count($user->followings)?>)</span>
                </div>
                <div class="box-header-buttons">
                    <a href="<?=$base;?>/friends.php?id=<?=$user->id;?>">ver todos</a>
                </div>
            </div>
            <div class="box-body friend-list">
                <?php if(count($user->followings) > 0): ?>
                    <?php foreach($user->followings as $item): ?>
                        <?php require 'partials/user-item.php'; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                

            </div>
        </div>

    </div>
    <div class="column pl-5">

        <div class="box">
            <div class="box-header m-10">
                <div class="box-header-text">
                    Fotos
                    <span>(<?=count($user->photos);?>)</span>
                </div>
                
                <div class="box-header-buttons">
                    <a href="<?=$base?>/photos.php?id=<?=$user->id;?>">ver todas</a>
                </div>
                
            </div>
            <div class="box-body row m-20">
                
                <?php if(count($user->photos) > 0): ?>
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
                <?php endif; ?>
                
            </div>
        </div>

        <?php if($id == $userInfo->id): ?>
            <?php require 'partials/feed-editor.php'; ?>
        <?php endif; ?>
        
        <?php if(count($feed) > 0): ?>
            <?php foreach($feed as $feed_item): ?>
                <?php require 'partials/feed-item.php'; ?>
            <?php endforeach; ?>
        <?php else: ?>
                <?php if($id == $userInfo->id): ?>
                    Você não postou nada ainda.
                <?php else: ?>
                    Não há postagens deste usuário.
                <?php endif; ?>
        <?php endif; ?>

    </div>
    
</div>

</section>

<?php require 'partials/footer.php';?>
