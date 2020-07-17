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
    $activeMenu = "friends";
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

                    <div class="tabs">
                        <div class="tab-item" data-for="followers">
                            Seguidores
                        </div>
                        <div class="tab-item active" data-for="followings">
                            Seguindo
                        </div>
                    </div>

                    <div class="tab-content">
                        <div class="tab-body" data-item="followers">
                            
                            <div class="full-friend-list">

                                <?php foreach($user->followers as $follower): ?>
                                    <div class="friend-icon">
                                        <a href="<?=$base;?>/profile.php?id=<?=$follower->id;?>">
                                            <div class="friend-icon-avatar">
                                                <img src="<?=$base;?>/media/avatars/<?=$follower->avatar;?>" />
                                            </div>
                                            <div class="friend-icon-name">
                                                <?= $follower->name; ?>
                                            </div>
                                        </a>
                                    </div>
                                <?php endforeach; ?>

                            </div>

                        </div>

                        <div class="tab-body" data-item="followings">
                            
                            <div class="full-friend-list">

                                <?php foreach($user->followings as $following): ?>
                                    <div class="friend-icon">
                                        <a href="<?=$base;?>/profile.php?id=<?=$following->id;?>">
                                            <div class="friend-icon-avatar">
                                                <img src="<?=$base;?>/media/avatars/<?=$following->avatar;?>" />
                                            </div>
                                            <div class="friend-icon-name">
                                                <?= $following->name; ?>
                                            </div>
                                        </a>
                                    </div>
                                <?php endforeach; ?>

                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
        
    </div>

</section>

<?php require 'partials/footer.php';?>
