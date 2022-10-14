// const { add } = require("lodash");

let login_logo = document.getElementById('login_logo');
let login_modal = document.getElementById('login_container');
let back_modal = document.getElementById('back_modal');
let close_modal = document.getElementById('close_modal');
let login_btn = document.getElementById('login_btn');

//formでのEnterキー登録不可
$(function(){
    $("input").on("keydown", function(e) {
        if ((e.which && e.which === 13) || (e.keyCode && e.keyCode === 13)) {
            return false;
        } else {
            return true;
        }
    });
});

//奇数行目だけ背景色変更
$(document).ready(function(){
    add_back_color2_yellow();
});

function add_back_color2_yellow(){
    $('tr:even').addClass('backgroundcolor_yellow');
}

if(login_logo){
    login_logo.addEventListener('click',function(e){
        console.log('aaaaaaaaa');
        e.preventDefault();
        $('#back_modal').css({'display':'block'});
        $('#back_modal').toggleClass('back_modal');
    })
}

//無限スクロール
$(window).on("scroll", function (){
    // スクロール位置
    var document_h = $(document).height();              
    var window_h = $(window).height() + $(window).scrollTop();    
    var scroll = (document_h - window_h);

    // 画面最下部にスクロールされている場合
    if (scroll <= 1) {
        // ajaxコンテンツ追加処理
        ajax_add_tweet();
    }
});


//ツイートバリデーション
let tweet = document.getElementById('tweet_formbox');
if(tweet){
    tweet.addEventListener('change',function(e){
        if(tweet){
            //エラー文初期化
            document.getElementById('error_tweet').innerHTML = '';
    
            //文字数オーバー時、エラー文表示
            if(tweet.value.length >300){
                document.getElementById('error_tweet').innerHTML = 'ツイートは300文字以内にしてください' + '(現在' + tweet.value.length + '文字)';
            }
        }
    })
}

 //メールアドレス未入力エラー
 function input_email(){
    let email = document.getElementById('email').value;
    if(!email){
        document.getElementById('email_error').innerHTML='メールアドレスを入力してください';
    }
}

//パスワード未入力エラー
function input_password(){
    let password = document.getElementById('password').value;
    if(!password){
        document.getElementById('password_error').innerHTML='パスワードを入力してください';
    }
}

//モーダル非表示：「閉じる」クリック
if(close_modal){
    close_modal.addEventListener('click',function(e){
        $('#back_modal').css({'display':'none'});
        $('#back_modal').toggleClass('back_modal');
    })
}

//いいねボタン押下時
let good_btn = document.getElementById('good');

let good = document.getElementsByClassName('good');

var goods = Array.from(good);

goods.forEach(function(target){
    target.addEventListener('click',function(){
        let $this = $(this); 
        let tweet_id = $this.data('tweet-id');
        let user_id = $this.data('user-id');
    
        $.ajax({
            headers: {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }, 
            type:'POST',
            url:'/good_ajax',
            dataType:'json',
            data:{ tweet_id:tweet_id,
                    user_id:user_id}
        }).done(function(data){
            console.log('aaa');
            $this.toggleClass('font_red');
        }).fail(function(msg){
            console.log('失敗');
            $this.toggleClass('font_red');
        })
    });
})

//フォローボタン押下時
let follow_btn = document.getElementById('follow');

if(follow_btn){
    follow_btn.addEventListener('click',function(){
        let $this = $(this);
        let follow_id = $this.data('follow_id');
        let follower_id = $this.data('follower_id');
        let follow = 'フォロー';

        $.ajax({
            headers: {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }, 
            type:'POST',
            url:'/follow_ajax',
            dataType:'json',
            data:{ follow_id:follow_id,
                follower_id:follower_id}
        }).done(function(data){
            console.log(data);
            if(follow_btn.innerHTML == follow){
                follow_btn.innerHTML = 'フォロー中';
            }else{
                follow_btn.innerHTML = 'フォロー';
            }
        }).fail(function(msg){
            console.log('失敗');
        })
    })
}

//ツイートのajax読み込み
function ajax_add_tweet(){
    // 追加ツイート
    let add_content = "";

    // コンテンツ件数           
    let count = $("#count").val();

    // ajax処理
    $.post({
        headers: {
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }, 
        type: "post",
        datatype: "json",
        url: "/infinite_scroll",
        data:{ count : count }
    }).done(function(datas){
        let data = JSON.parse(datas);
        
        // コンテンツ生成
        $.each(data,function(key,val){
            add_content += "<tr><th class='tweet_th'><a href='' class='detail_user'>"+val['user']['name']+"</a></th>";
            add_content += "<td class='tweet_td'><a href='' class='detail_tweet'>"+val['tweet']+"</a></td>";
            add_content += "<td id='goods'><button type='button' class='good_btn good' id='good'><i>&hearts;</i></button></td></tr>";
        })

        // コンテンツ追加
        $("#tweet_content").append(add_content);

        add_back_color2_yellow();

        if(data.length !== 2){
            $('#no_tweet').css({'display':'block'});
        }

        // 取得件数を加算してセット
        count = Number(count) + Number(data.length);
        $("#count").val(count);
        console.log(count);
    }).fail(function(e){
        console.log(e);
    })
}



