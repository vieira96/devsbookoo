<?php
require_once 'config.php';

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Login</title>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1"/>
    <link rel="stylesheet" href="<?=$base;?>/assets/css/login.css" />
</head>
<body>
    <header>
        <div class="container">
            <a href=""><img src="<?=$base;?>/assets/images/devsbook_logo.png" /></a>
        </div>
    </header>
    <section class="container main">
        <form method="POST" action="login_action.php">
            <?php if(!empty($_SESSION['flash'])): ?>
                <div class="flash"><?= $_SESSION['flash'];?></div>
                <?php unset($_SESSION['flash']); ?>
            <?php endif; ?>
            <input placeholder="Digite seu e-mail" class="input" type="email" name="email" />

            <input placeholder="Digite sua senha" class="input" type="password" name="password" />

            <input class="button" type="submit" value="Acessar o sistema" />

            Ainda não tem conta?<a href="<?=$base;?>/signup.php"> Cadastre-se</a>
        </form>
    </section>
</body>
</html>