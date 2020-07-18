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
        <form method="POST" action="signup_action.php">
            <?php if(!empty($_SESSION['flash'])): ?>
                <div class="flash"><?= $_SESSION['flash'];?></div>
                <?php unset($_SESSION['flash']); ?>
            <?php endif; ?>

            <input placeholder="Digite seu nome completo" class="input" type="text" name="name" />

            <input placeholder="Digite seu e-mail" class="input" type="email" name="email" />

            <input placeholder="Digite sua senha" class="input" type="password" name="password" />
            
            <input id="birthdate" placeholder="Digite sua data de nascimento" class="input" type="text" name="birthdate" />

            <input class="button" type="submit" value="Fazer cadastro" />

            Já tem conta?<a href="<?=$base;?>/login.php"> Fazer login.</a>
        </form>
    </section>
    <script src="https://unpkg.com/imask"></script>
    <script>
        IMask(
            document.getElementById("birthdate"),
            {mask:'00/00/0000'}
        );
    </script>
</body>
</html>