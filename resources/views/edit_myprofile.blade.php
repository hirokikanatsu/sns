
@extends('layouts.layout')

@section('content')
    @if(session('f_msg'))
        <div class='f_msg' id='msg'>{{session('f_msg')}}</div>
    @endif
    <div class="card-body t_center">
        <form method="POST" action="{{ route('edit_myprofile') }}" enctype='multipart/form-data'>
            @csrf

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <li class='font_red err_msg'>{{ $error }}</li>
                @endforeach
            @endif

            <div class="row mb-3 mt100">
                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('名前') }}</label>

                <div class="col-md-6">
                    <input id="name" type="text" class="edit_profile form-control @error('name') is-invalid @enderror" name="name" value="{{ Auth::user()->name }}" required autocomplete="name" autofocus>

                    <!-- @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror -->
                </div>
            </div>

            <div class="row mb-3 mt100">
                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('メールアドレス') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="edit_profile form-control @error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email }}" required autocomplete="email">

                    <!-- @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror -->
                </div>
            </div>

            <div class="row mb-3 mt100">
                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('パスワード') }}</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="edit_profile form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        <!-- @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror -->
                </div>
            </div>

            <div class="row mb-3 mt100">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('確認用パスワード') }}</label>

                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="edit_profile form-control" name="password_confirmation" required autocomplete="new-password">
                </div>
            </div>

            <div class="row mb-3 mt100">
                <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('画像') }}</label>

                <div class="col-md-6">
                    <input id="image" type="file"  name="image" autocomplete="new-image" >

                    <!-- @error('image')
                        <span class="invalid-feedback font_red" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror -->
                </div>
            </div> 

            <div class="row mb-0 mt100">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="edit_profile_btn btn btn-primary">
                        {{ __('変更') }}
                    </button>
                </div>
            </div>
        </form>
        <form action="{{route('back_page')}}" method="POST">
            @csrf
            <button class='back_btn' type="submit" name="back_page" value="mypage">戻る</button>
        </form>
@endsection