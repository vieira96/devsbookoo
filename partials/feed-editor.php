<?php
    $firstName = current(explode(' ', $userInfo->name));
?>

<div class="box feed-new">
    <div class="box-body">
        <div class="feed-new-editor m-10 row">
            <div class="feed-new-avatar">
                <img src="<?=$base;?>/media/avatars/<?=$userInfo->avatar;?>" />
            </div>
            <div class="feed-new-input-placeholder">O que você está pensando, <?=$firstName?>?</div>
            <div class="feed-new-input" contenteditable="true"></div>
            
            <div class="feed-new-photo">
                <img src="<?=$base;?>/assets/images/photo.png" />
                <input type="file" name="photo" class="feed-new-file" accept="image/jpg,image/jpeg,image/png"/>
            </div>

            <div class="feed-new-send">
                <img src="<?=$base;?>/assets/images/send.png" />
            </div>
            <form class="feed-new-form" method="POST" action="<?=$base;?>/feed_editor_action.php">                <input type="hidden" name="body">
            </form>
        </div>
    </div>
</div>

<script>
    let feedInput = document.querySelector(".feed-new-input");
    let feedSubmit = document.querySelector(".feed-new-send");
    let feedForm = document.querySelector(".feed-new-form");

    let feedPhoto = document.querySelector('.feed-new-photo');
    let feedFile = document.querySelector('.feed-new-file');

    feedPhoto.addEventListener('click', function(){
        feedFile.click();
    });

    feedFile.addEventListener('change', async function(){
        let photo = feedFile.files[0];
        let formData = new FormData();

        formData.append('photo', photo);
        let req = await fetch('ajax_upload.php', {
            method: 'POST',
            body: formData
        });
       
        let json = await req.json();
        
        if(json.error != '') {
            alert(json.error);
        }

        console.log(json[0]);
        

        window.location.href = window.location.href;
    });

    feedSubmit.addEventListener('click', function(){
        let value = feedInput.innerText.trim();

        feedForm.querySelector('input[name=body]').value = value;
        feedForm.submit();
    });

</script>