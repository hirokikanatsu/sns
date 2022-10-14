
let login_logo = document.getElementById('login_logo');
let login_modal = document.getElementById('login_container');
let back_modal = document.getElementById('back_modal');
let close_modal = document.getElementById('close_modal');
let login_btn = document.getElementById('login_btn');

//奇数行目だけ背景色変更
$(document).ready(function(){
    $('tr:odd').addClass('backgroundcolor_yellow');
});

if(login_logo){
    login_logo.addEventListener('click',function(e){
        console.log('aaaaaaaaa');
        e.preventDefault();
        $('#back_modal').css({'display':'block'});
        $('#back_modal').toggleClass('back_modal');
    })
}

if(login_btn){
    login_btn.addEventListener('click',function(e){
        alert('assss');
        // e.preventDefault();
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
function tweet_validation(){
    let count = document.getElementById('tweet_formbox').value();
    console.log(count);
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

function inputChange(){
    console.log('Change');
}

let email = document.getElementById('email').val();
console.log(email);
if(email.addEventListener('change',function(){
    console.log(email);
}));

    

// if(good_btn){
//     good_btn.addEventListener('click',function(){
//         let $this = $(this); 
//         let tweet_id = $this.data('tweet-id');
//         let user_id = $this.data('user-id');
    
//         $.ajax({
//             headers: {
//                 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
//             }, 
//             type:'POST',
//             url:'/good_ajax',
//             dataType:'json',
//             data:{ tweet_id:tweet_id,
//                     user_id:user_id}
//         }).done(function(data){
//             console.log('aaa');
//             $this.toggleClass('font_red');
//         }).fail(function(msg){
//             console.log('失敗');
//             $this.toggleClass('font_red');
//         })
//     });
// }

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
    }).done(function(data){

        console.log(data);
        
        // // コンテンツ生成
        // $.each(data,function(key, val){
        //     add_content += "<div>"+val.content+"</div>";
        // })
        // // コンテンツ追加
        // $("#content").append(add_content);
        // // 取得件数を加算してセット
        // count += data.length
        // $("#count").val(count);
    }).fail(function(e){
        console.log(e);
    })
}



