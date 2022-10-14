<div id='back_modal' style="display: none;" >
<div class="login_container" id='login_container'>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="t_center">
                <div class='title_font'>{{ __('Login') }}</div>
                    <div class="card-body">
                <!-- <x-alert type="danger" :session="session('login_error')"></x-alert> -->
                        <form method="POST" action="{{ route('login_conf') }}">
                            @csrf

                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <li class='font_red err_msg'>{{ $error }}</li>
                                @endforeach
                            @endif
                            <div class="form-item">
                                <p class="formLabel">Email</p>
                                <input type="email" name="email" id="email" class="form-style" onchange="input_email()" autocomplete="off"/>
                                <span id='email_error' class='font_red bold'></span>
                            </div>

                            <div class="form-item">
                                <p class="formLabel">Password</p>
                                <input type="password" name="password" id="password" class="form-style" onchange="input_password()"/>
                                <span id='password_error' class='font_red bold'></span>
                                <p class='mt30 forget_pass'><a href="#" >Forgot Password ?</a></p>  
                            </div>

                            <div class="form-item">
                                <p class="pull-left register"><a href="#">Register</a></p>
                                <input type="submit" class="login pull-right" id='login_btn' value="Log In">
                                <div class="clear-fix"></div>
                            </div>  
                    </div>
                    <div id='close_modal'>閉じる</div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- <script>

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
let close_modal = document.getElementById('close_modal');
if(close_modal){
    close_modal.addEventListener('click',function(e){
        $('#back_modal').css({'display':'none'});
        $('#back_modal').toggleClass('back_modal');
    })
}

</script> -->