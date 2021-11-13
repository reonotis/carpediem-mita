
jQuery(function(){
    // .cq_imgArea クラスが使われているか判断
    if(jQuery('.cq_imgArea').length){
        // 最後の .cq_imgArea の直後にpopupを非表示で作成しておく
        jQuery('.cq_imgArea').last().after('<div class="cq_popup" id="cq_popup" style="display: none;" ><img src="" ></div>');
    }
});

// 画像をクリックしたときに表示させる
jQuery(function(){
    jQuery('.cq_imgArea').on('click', function() {
        // クリックした画像のソースを取得
        var src_url = jQuery(this).children().attr('src');
        console.log(src_url)

        // popUp内のimgタグのsrcを書き換える
        jQuery('#cq_popup').children().attr('src',src_url);

        // popUpを表示する
        jQuery('#cq_popup').slideToggle(250 ,'swing');
    });
});

// popUpを非表示にする
jQuery(function(){
    jQuery('.cq_popup').on('click', function() {
        jQuery('#cq_popup').slideToggle(250 ,'swing');
    });
});
