@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="t_center">
                <div class='title_font'>{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mt50">
                            <label for="email" id='email'>{{ __('メールアドレス') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-controller @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt50">
                            <label for="password" class=" text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6 t_center">
                                <input id="password" type="password" class="form-controller @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt50">
                            <div >
                                <div class="form-check">
                                    <input style=" transform: scale(2)" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="ml20" for="remember">
                                        {{ __('ログイン状態を保存') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mt30 mb-0">
                            <div class="">
                                <button type="submit" class="btn-primary button_font">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="btn-link pass_font" href="{{ route('password.request') }}">
                                {{ __('パスワードを忘れた方はこちら') }}
                            </a>
                        @endif
                    </form>

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link register_font" href="{{ route('register') }}">{{ __('新規登録はこちらから') }}</a>
                        </li>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
