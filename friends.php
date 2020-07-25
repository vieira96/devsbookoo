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

                                <?php foreach($user->followers as $item): ?>
                                    <?php require 'partials/user-item.php'; ?>
                                <?php endforeach; ?>

                            </div>

                        </div>

                        <div class="tab-body" data-item="followings">
                            
                            <div class="full-friend-list">

                                <?php foreach($user->followings as $item): ?>
                                    <?php require 'partials/user-item.php'; ?>
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
