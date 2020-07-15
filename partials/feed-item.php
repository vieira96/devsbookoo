<div class="box feed-item">
    <div class="box-body">
        <div class="feed-item-head row mt-20 m-width-20">
            <div class="feed-item-head-photo">
                <a href=""><img src="<?=$base;?>/media/avatars/<?=$feed_item->user->avatar;?>" /></a>
            </div>
            <div class="feed-item-head-info">
                <a href=""><span class="fidi-name"><?=$feed_item->user->name;?></span></a>
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
                <span class="fidi-date"><?=date('d/m/Y', strtotime($feed_item->created_at))?></span>
            </div>
            <div class="feed-item-head-btn">
                <img src="<?=$base?>/assets/images/more.png" />
            </div>
        </div>
        <div class="feed-item-body mt-10 m-width-20">
            <?=nl2br($feed_item->body);?>
        </div>
        <div class="feed-item-buttons row mt-20 m-width-20">
            <div class="like-btn <?= $feed_item->liked?'on':''?>"><?=$feed_item->likeCount?></div>
            <div class="msg-btn"><?=count($feed_item->comments)?></div>
        </div>
        <div class="feed-item-comments">
        
            <div class="fic-answer row m-height-10 m-width-20">
                <div class="fic-item-photo">
                    <img src="<?=$base?>/media/avatars/<?=$userInfo->avatar;?>" />
                </div>
                <input type="text" class="fic-item-field" placeholder="Escreva um comentário" />
            </div>

        </div>
    </div>
</div>
