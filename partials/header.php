<?php
    $firstName = current(explode(' ', $userInfo->name));
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Devsbook</title>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1"/>
    <link rel="stylesheet" href="<?=$base?>/assets/css/style.css" />
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <a href="<?=$base?>"><img src="<?=$base?>/assets/images/devsbook_logo.png" /></a>
            </div>
            <div class="head-side">
                <div class="head-side-left">
                    <div class="search-area">
                        <form method="GET" action="<?=$base;?>/search.php">
                            <input type="search" placeholder="Pesquisar" name="s" />
                        </form>
                    </div>
                </div>
                <div class="head-side-right">
                    <a href="<?=$base?>/profile.php" class="user-area">
                        <div class="user-area-text"><?=$firstName;?></div>
                
                        <div class="user-area-icon">
                            <img src="<?=$base?>/media/avatars/<?=$userInfo->avatar;?>" />
                        </div>
                    </a>
                    <a href="<?=$base?>/logout.php" class="user-logout">
                        <img src="assets/images/power_white.png" />
                    </a>
                </div>
            </div>
        </div>
    </header>
    <section class="container main">
