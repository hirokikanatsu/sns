
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
        console.log('wwwww');
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

if(back_modal){
    back_modal.addEventListener('click',function(){
        console.log('qqqqq');できない,初めからイベント内容見直す    
        $('.back_modal').css({'display':'none'});
        $('.back_modal').toggleClass('back_modal');
    })
}

if(close_modal){
    $(document).on('click','close_modal',function(){
        $('#back_modal').css({'display':'none'});
        $('#back_modal').toggleClass('back_modal');
    })
}



// document.getElementById('delete_tweet').onclick = delete();

// if(window.confirm('本当に削除しますか??')){
//     alert('aaaaa');
//     window.location.href = "{{ url::to('delete_tweet') }}";
// }

// console.log('aaaaa');


//いいねボタン押下時
let good_btn = document.getElementById('good');

let good = document.getElementsByClassName('good');

var goods = Array.from(good);

goods.forEach(function(target){
    target.addEventListener('click',function(){
        console.log('www');
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



