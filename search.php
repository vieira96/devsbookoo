<?php

require_once 'config.php';
require_once 'models/Auth.php';
require_once 'dao/PostDaoMysql.php';
require_once 'dao/UserDaoMysql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$activeMenu = "";
$userDao = new UserDaoMysql($pdo);

$searchTerm = filter_input(INPUT_GET, 's', FILTER_SANITIZE_STRIPPED);

if(empty($searchTerm)) {
    header("Location: ".$base);
    exit;
}

$user = $userDao->findByName($searchTerm);

require 'partials/header.php';
require 'partials/menu.php'; 
?>
<section class="feed mt-10">
    <div class="row">
        <div class="column pr-5">
            
            <?php if($user): ?>
                <h2>Pesquisando por: <?=$searchTerm;?></h2>

                <div class="full-friend-list">
                    <?php foreach($user as $item): ?>
                        <?php require 'partials/user-item.php'; ?>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                Nenhum resultado encontrado.
            <?php endif; ?>
        
        </div>

        <div class="column side pl-5">
            <?php require 'partials/right-side.php'; ?>
        </div>
    </div>
</section>  

<?php require 'partials/footer.php';?>



