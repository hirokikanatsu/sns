
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
        e.preventDefault();
        $('#back_modal').css({'display':'block'});
        $('#back_modal').toggleClass('back_modal');
    })
}


//無限スクロール
if(document.getElementById('timeline_space')){
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
}


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
if(document.getElementById('email')){
    let email = document.getElementById('email').val();
    console.log(email);
    if(email.addEventListener('change',function(){
        console.log(email);
    }));
}


    

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


//チャットの初期表示を最新のところに合わせる
if(document.getElementById('room')){
    let room = document.getElementById('room');
    room.scrollTo(0, room.scrollHeight);
}

if(document.getElementById('chat_btn_send')){
    if(document.getElementById('chat_btn_send').addEventListener('click',function(e){
        send_chat();
    }));
}

//チャット送信ボタン押下時
function send_chat(){

    let send_user = document.getElementById('send_id').value;
    let receive_user = document.getElementById('receive_id').value;
    let contents = document.getElementById('contents').value;

    $.ajax({
        headers: {
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }, 
        type:'POST',
        url:'/store_chat',
        dataType:'json',
        data:{ 'send_user':send_user,
                'receive_user':receive_user,
                'contents':contents}
    }).done(function(data){
        console.log(data);
        document.getElementById('contents').value = '';
    }).fail(function(msg){
        console.log('失敗');
    })
}

// let search_user_name = document.getElementById('search_user');
// console.log('qqqqq');
// if(search_user_name){
//     search_user_name.click(function(e){
//         e.preventDefault();

//         ajax_show_users_name();
//     })
// }

// function ajax_show_users_name(){
//         console.log('qqqqq');     
// }


