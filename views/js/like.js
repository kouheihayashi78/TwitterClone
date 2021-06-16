//////////////////////
//いいね！用のJavaScript
//////////////////////

$(function () {
    //いいねがクリックされた時
    $('.js-like').click(function () {
        const this_obj = $(this);
        const like_id = $(this).data('like_id');
        const like_count_obj = $(this).parent().find('.js-like-count');
        let like_count = Number(like_count_obj.html());

        if (like_id) {
            // いいね取り消し
            // いいねカウントを減らす
            like_count--;
            like_count_obj.html(like_count);
            this_obj.data('like_id',null);

            // いいねボタンをグレーに変更
            $(this).find('img').attr('src', '../views/img/icon-heart.svg');
        } else {
            // いいね付与
            // いいねカウントを増やす
            like_count++;
            like_count_obj.html(like_count);
            this_obj.data('like_id',true);

            // いいねボタンを青に変更
            $(this).find('img').attr('src', '../views/img/icon-heart-twitterblue.svg');
        }
    })
})