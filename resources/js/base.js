

// document.getElementById('delete_tweet').onclick = delete();

// if(window.confirm('本当に削除しますか??')){
//     alert('aaaaa');
//     window.location.href = "{{ url::to('delete_tweet') }}";
// }

// console.log('aaaaa');


//いいねボタン押下時
let btn = document.getElementById('good');
// let goods = document.getElementById('goods').children[0][button#];
// console.log(goods);
if(btn){
    btn.addEventListener('click',function(){
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




