<?php

require_once 'config.php';
require_once 'models/Auth.php';
require_once 'dao/UserDaoMysql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$activeMenu = "config";

$userDao = new UserDaoMysql($pdo);

require 'partials/header.php';
require 'partials/menu.php'; 
?>
<section class="feed mt-10">
    <h1>Configurações</h1>
    <form class="config-form" method="POST" enctype="multipart/form-data" action="settings_action.php">
    
        <?php if(!empty($_SESSION['flash'])): ?>
            <div class="flash"><?= $_SESSION['flash'];?></div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <?php if(!empty($_SESSION['success'])): ?>
            <div class="success"><?= $_SESSION['success'];?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <label>
            <span>Novo Avatar:</span><br>
            <input type="file" name="avatar">
        </label>

        <img class ="mini" src="<?=$base?>/media/avatars/<?=$userInfo->avatar;?>">

        <label>
            <span>Nova Capa:</span><br>
            <input type="file" name="cover">
        </label>
        <img class="mini" 60px;" src="<?=$base?>/media/covers/<?=$userInfo->cover;?>">
        
        <hr>

        <label>
            <span>Nome:</span> <br>
            <input type="text" name="name" value="<?=$userInfo->name;?>">
        </label>

        <label>
            <span>Data de Nascimento:</span> <br>
            <input type="text" id="birthdate" name="birthdate" value="<?=date('d/m/Y', strtotime($userInfo->birthdate));?>">
        </label>

        <label>
            <span>Cidade:</span> <br>
            <input type="text" name="city" value="<?=$userInfo->city;?>">
        </label>

        <label>
            <span>Trabalho:</span> <br>
            <input type="text" name="work" value="<?=$userInfo->work;?>">
        </label>

        <hr>

        <label>
            <span>Senha:</span> <br>
            <input type="password" name="password">
        </label>

        <label>
            <span>Confirmar Senha:</span> <br>
            <input type="password" name="password_confirmation">
        </label>

        <button class="button"> Salvar </button>

    </form>
</section>

<script src="https://unpkg.com/imask"></script>
<script>
    IMask(
        document.getElementById("birthdate"),
        {mask:'00/00/0000'}
    );
</script>

<?php require 'partials/footer.php';?>