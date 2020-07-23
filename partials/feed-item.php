    <?php require_once 'partials/feed-item-script.php'; ?>

<div class="box feed-item" data-id="<?=$feed_item->id?>">
    <div class="box-body">
        <div class="feed-item-head row mt-20 m-width-20">
            <div class="feed-item-head-photo">
                <a href="<?=$base?>/profile.php?id=<?=$feed_item->user->id;?>"><img src="<?=$base;?>/media/avatars/<?=$feed_item->user->avatar;?>" /></a>
            </div>
            <div class="feed-item-head-info">
                <a href="<?=$base?>/profile.php?id=<?=$feed_item->user->id;?>"><span class="fidi-name"><?=$feed_item->user->name;?></span></a>
                <span class="fidi-action">
                    <?php
                        switch($feed_item->type){
                            case 'text':
                                echo "Fez um post";
                                break;
                            case 'photo':
                                echo "Postou uma foto";
                                break;
                        }
                    ?>
                </span>
                <br/>
                <span class="fidi-date">
                    <?php
                        $hourFrom = new DateTime($feed_item->created_at);
                        $hourTo = new DateTime('now');
                        $diff = date_diff($hourTo, $hourFrom);
                        switch($diff){

                            case $diff->d > 2:
                                echo date('d/m/Y', strtotime($feed_item->created_at));
                                echo " às " . date('H:i');
                                break;
                            case $diff->d >= 1:
                                echo $diff->d . " d";
                                break;
                            case $diff->h > 1:
                                echo $diff->h . " hrs";
                                break;
                            case $diff->h == 1:
                                echo $diff->h . " hr";
                                break;
                            case $diff->i >= 1:
                                echo $diff->i . " min";
                                break;
                            default:
                                echo $diff->s . " sec";
                                break;
                            break;
                        }
                    ?>
                </span>
            </div>
            <?php if($feed_item->mine): ?>
                <div class="feed-item-head-btn">
                    <img src="<?=$base?>/assets/images/more.png" />
                </div>
            <?php endif; ?>
        </div>
        <?php
            switch($feed_item->type){
                case 'text':
                    echo "<div class='feed-item-body mt-10 m-width-20'>";
                    echo nl2br($feed_item->body);
                    echo "</div>";
                    break;
                case 'photo':
                    echo "<div class='feed-item-body mt-10 m-width-20' style='display: flex; justify-content: center;'>";
                    echo "<img src='".$base."/media/uploads/".$feed_item->body."'/>";
                    echo "</div>";
                    break;
            }
        ?>
        <div class="feed-item-buttons row mt-20 m-width-20">
            <div class="like-btn <?= $postLikeDao->isLiked($feed_item->id, $userInfo->id) ?'on':''?>"><?=$feed_item->likeCount?></div>
            <div class="msg-btn" data-id="<?=$feed_item->id;?>" ><?=count($feed_item->comments)?></div>
        </div>

        <div class="feed-item-comments">
        
            <div class="feed-item-comments-area">
                <?php foreach($feed_item->comments as $comment): ?>
                    <div class="fic-item row m-height-10 m-width-20">
                        <div class="fic-item-photo">
                            <a href="<?=$base;?>/profile.php?id=<?=$comment->user->id;?>"><img src="<?=$base?>/media/avatars/<?=$comment->user->avatar;?>" /></a>
                        </div>
                        <div class="fic-item-info">
                            <a href="<?=$base;?>/profile.php?id=<?=$comment->user->id;?>"><?=$comment->user->name;?></a>
                            <?=$comment->body?>
                        </div>
                    </div>
                <?php endforeach; ?> 
            </div>
            
            <div class="fic-answer row m-height-10 m-width-20">
                <div class="fic-item-photo">
                    <img src="<?=$base?>/media/avatars/<?=$userInfo->avatar;?>" />
                </div>
                <input type="text" class="fic-item-field" placeholder="Escreva um comentário" />
            </div>
            
        </div>
    </div>
</div>
