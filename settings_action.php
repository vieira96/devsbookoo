<?php 
require_once 'config.php';
require_once 'models/Auth.php';
require_once 'dao/UserDaoMysql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

$userDao = new UserDaoMysql($pdo);

$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRIPPED);
$birthdate = filter_input(INPUT_POST, 'birthdate');
$city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRIPPED);
$work = filter_input(INPUT_POST, 'work', FILTER_SANITIZE_STRIPPED);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRIPPED);
$password_confirmation = filter_input(INPUT_POST, 'password_confirmation', FILTER_SANITIZE_STRIPPED);
$avatar = filter_input(INPUT_POST, 'avatar');
$cover = filter_input(INPUT_POST, 'cover');

if($name) {
    $userInfo->name = $name;

    $birthdate = explode('/', $birthdate);
    if(count($birthdate) != 3 ) {
        $_SESSION['flash'] = "Data de nascimento inválida";
        header("Location: ".$base."/settings.php");
        exit;
    }  

    if(strlen($birthdate[2]) < 4) {
        $_SESSION['flash'] = "Data de nascimento inválida";
        header("Location: ".$base."/settings.php");
        exit;
    }

    $birthdate = $birthdate[2] . "-" . $birthdate[1] . "-" . $birthdate[0];
    if(!strtotime($birthdate)) {
        $_SESSION['flash'] = "Data de nascimento inválida";
        header("Location: ".$base."/settings.php");
        exit;
    }

    $userInfo->birthdate = $birthdate;
    $userInfo->city = $city;
    $userInfo->work = $work;

    if(!empty($password)) {
        if($password === $password_confirmation) {
            $userInfo->password = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $_SESSION['flash'] = "Senhas não conferem.";
            header("Location: ".$base."/settings.php");
            exit;
        }
    }

    if(isset($_FILES['avatar']) && !empty($_FILES['avatar']['tmp_name'])) {
        $newAvatar = $_FILES['avatar'];
        $acceptTypes = ['image/jpeg', 'image/jpg', 'image/png'];

        if(in_array($newAvatar['type'], $acceptTypes)) {
            
            $oldProfilePick = $userInfo->avatar;

            $avatarName = md5(time().rand(0,9999)).'.jpg';

            move_uploaded_file($newAvatar['tmp_name'], './media/avatars/'.$avatarName);

            if($oldProfilePick != 'default.jpg') {
                unlink("./media/avatars/".$oldProfilePick);
            }
            
            $userInfo->avatar = $avatarName;

        } else {
            $_SESSION['flash'] = "Tipo de arquivo inválido, selecione uma foto.";
            header("Location: ".$base."/settings.php");
            exit;
        }

    }

    if(isset($_FILES['cover']) && !empty($_FILES['cover']['tmp_name'])) {
        
        $newCover = $_FILES['cover'];
        $acceptTypes = ['image/jpeg', 'image/jpg', 'image/png'];

        if(in_array($newCover['type'], $acceptTypes)) {
            
            $oldCover = $userInfo->cover;

            $coverName = md5(time().rand(0,9999)).'.jpg';

            move_uploaded_file($newCover['tmp_name'], './media/covers/'.$coverName);

            if($oldCover != 'cover.jpg') {
                unlink("./media/covers/".$oldCover);
            }
            
            $userInfo->cover = $coverName;

        } else {
            $_SESSION['flash'] = "Tipo de arquivo inválido, selecione uma foto.";
            header("Location: ".$base."/settings.php");
            exit;
        }

    }

    $userDao->update($userInfo);
    $_SESSION['success'] = "Dados atualizados com sucesso";
}

header("Location: ".$base."/settings.php");
exit;

?>