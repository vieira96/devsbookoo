<?php

require_once 'config.php';
require_once 'models/Auth.php';
require_once 'dao/PostDaoMysql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$activeMenu = "home";

$postDao = new PostDaoMysql($pdo);
$feed = $postDao->getHomeFeed($userInfo->id);
$postLikeDao = new PostLikeDaoMysql($pdo);

require 'partials/header.php';
require 'partials/menu.php'; 
?>
<section class="feed mt-10">
    <div class="row">
        <div class="column pr-5">
            
            <?php require 'partials/feed-editor.php';?>
            <?php foreach($feed as $feed_item): ?>
                <?php require 'partials/feed-item.php';?>
            <?php endforeach; ?>
        
        </div>

        <div class="column side pl-5">
            <?php require 'partials/right-side.php'; ?>
        </div>
    </div>
</section>

<?php require 'partials/footer.php';?>



