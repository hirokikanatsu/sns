

// document.getElementById('delete_tweet').onclick = delete();

// if(window.confirm('本当に削除しますか??')){
//     alert('aaaaa');
//     window.location.href = "{{ url::to('delete_tweet') }}";
// }

// console.log('aaaaa');


//いいねボタン押下時
let good_btn = document.getElementById('good');

if(good_btn){
    good_btn.addEventListener('click',function(){
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
            console.log('成功');
            $this.toggleClass('font_red');
        }).fail(function(msg){
            console.log('失敗');
            $this.toggleClass('font_red');
        })
    });
}

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



