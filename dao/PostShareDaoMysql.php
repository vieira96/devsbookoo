<?php 

require_once 'config.php';
require_once 'models/PostShare.php';
require_once 'models/Auth.php';


class PostShareDaoMysql {

    private $pdo;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    }

    public function insert($id_post, $id_user)
    {
        $sql = $this->pdo->prepare("INSERT INTO postshares (id_post, id_user, created_at) 
        VALUES (:id_post, :id_user, NOW())");
        $sql->bindValue(":id_post", $id_post);
        $sql->bindValue(":id_user", $id_user);
        $sql->execute();
    }

    public function findPostByIdPost($id_post)
    {
        $sql = $this->pdo->prepare("SELECT * FROM postshares WHERE id_post = :id_post");
        $sql->bindValue(":id_post", $id_post);
        $sql->execute();

        if($sql->rowCount() > 0) {
            return true;
        }else {
            return false;
        }
        
    }

    public function getSharesCount($id_post)
    {
        $sql = $this->pdo->prepare("SELECT COUNT(*) AS c FROM postshares WHERE id_post = :id_post");
        $sql->bindValue(":id_post", $id_post);
        $sql->execute();

        $data = $sql->fetch();
        
        return $data['c'];
    }

    
}

