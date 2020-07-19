<?php

require_once 'config.php';
require_once 'models/Auth.php';
require_once 'dao/PostDaoMysql.php';
require_once 'dao/UserDaoMysql.php';
require_once 'dao/UserRelationDaoMysql.php';
require_once 'dao/PostLikeDaoMysql.php';

$activeMenu = '';
$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$urDao = new UserRelationDaoMysql($pdo);


$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRIPPED);

if(!$id){
    $id = $userInfo->id;
}

if($id == $userInfo->id) {
    $activeMenu = "profile";
}

$postDao = new PostDaoMysql($pdo);
$postLikeDao = new PostLikeDaoMysql($pdo);
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
$isFollowing = $urDao->isFollowing($userInfo->id, $id);

require 'partials/header.php';
require 'partials/menu.php'; 
?>

<section class="feed">

<div class="row">
    <div class="box flex-1 border-top-flat">
        <div class="box-body">
            <div class="profile-cover" style="background-image: url('<?=$base;?>/media/covers/<?=$user->cover;?>');"></div>
            <div class="profile-info m-20 row">
                <div class="profile-info-avatar">
                    <img src="<?=$base?>/media/avatars/<?=$user->avatar;?>" />
                </div>
                <div class="profile-info-name">
                    <div class="profile-info-name-text"><?=$user->name;?></div>
                    <?php if(!empty($user->city)): ?>
                        <div class="profile-info-location"><?=$user->city;?></div>
                    <?php endif; ?>
                </div>
                <div class="profile-info-data row">
                
                    <?php if($id != $userInfo->id): ?>
                        <div class="profile-info-item m-width-20">
                            <a class="button" href="<?=$base;?>/follow_action.php?id=<?=$id;?>"> <?php if($isFollowing): ?> Deixar de Seguir <?php else: ?> Seguir <?php endif; ?></a>
                        </div>
                    <?php endif; ?>
                    <div class="profile-info-item m-width-20">
                        <div class="profile-info-item-n"><?=count($user->followers)?></div>
                        <div class="profile-info-item-s">Seguidores</div>
                    </div>
                    <div class="profile-info-item m-width-20">
                        <div class="profile-info-item-n"><?=count($user->followings);?></div>
                        <div class="profile-info-item-s">Seguindo</div>
                    </div>
                    <div class="profile-info-item m-width-20">
                        <div class="profile-info-item-n"><?=count($user->photos);?></div>
                        <div class="profile-info-item-s">Fotos</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
