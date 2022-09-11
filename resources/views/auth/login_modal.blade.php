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
                                <input type="email" name="email" id="email" class="form-style" autocomplete="off"/>
                            </div>

                            <div class="form-item">
                                <p class="formLabel">Password</p>
                                <input type="password" name="password" id="password" class="form-style" />
                                <!-- <div class="pw-view"><i class="fa fa-eye"></i></div> -->
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