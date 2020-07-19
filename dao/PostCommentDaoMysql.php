<?php 

require_once 'config.php';
require_once 'models/PostComment.php';
require_once 'models/Auth.php';
require_once 'models/PostComment.php';
require_once 'dao/UserDaoMysql.php';


class PostCommentDaoMysql implements PostCommentDAO {

    private $pdo;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    }

    public function getComments($id_post)
    {
        $comments = [];

        $sql = $this->pdo->prepare("SELECT * FROM postcomments WHERE id_post = :id_post");
        $sql->bindValue(":id_post", $id_post);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            $userDao = new UserDaoMysql($this->pdo);

            foreach($data as $comment) {
                $commentItem = new PostComment();
                $commentItem->id = $comment['id'];
                $commentItem->id_post = $comment['id_post'];
                $commentItem->id_user = $comment['id_user'];
                $commentItem->body = $comment['body'];
                $commentItem->created_at = $comment['created_at'];
                $commentItem->user = $userDao->findById($commentItem->id_user);

                $comments[] = $commentItem;
            }
        }
        
        return $comments;
    }

    public function addComment(PostComment $pc)
    {
        $sql = $this->pdo->prepare("INSERT INTO postcomments 
        (id_post, id_user, body, created_at) VALUES (:id_post, :id_user, :body, NOW())");
        $sql->bindValue(":id_post", $pc->id_post);
        $sql->bindValue(":id_user", $pc->id_user);
        $sql->bindValue(":body", $pc->body);
        $sql->execute();
    }
}