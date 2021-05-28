@extends( 'common.layout' )

@section( 'header' )
<div class="uk-text-center uk-margin-top">
    <form class="uk-search uk-search-default uk-width-1-2" action="{{ route( 'inn_search' ) }}" method="GET">
        @csrf
        <input class="uk-search-input" type="search" name="address" placeholder="ロケーション" value="{{ old( 'location' ) }}" style="border-radius: 20px;">
        <button class="uk-search-icon-flip" type="submit" uk-search-icon></button>
    </form>
</div>
@endsection

@section( 'contents' )
<a  class="uk-margin-small-left" uk-icon="icon: arrow-left; ratio: 2" href="{{ route( 'user_home' ) }}"></a>

<div class="uk-text-center">
    <h2 class="uk-margin-medium-bottom">LA-Innsへようこそ</h2>
    @include( 'common.flash' )
    <form action="{{ route( 'login' ) }}" method="POST">
        @csrf
            <p>
                <label for="email">メールアドレス：</label>
                <input type="email" name="email" value="{{ old( 'email' ) }}">
            </p>
            <p>
                <label for="name">パスワード：</label>
                <input type="password" name="password" value="{{ old( 'password' ) }}">
            </p>
            <p>
                <button class="uk-button uk-button-default" type="submit">ログイン</button>
            </p>
            <p>または</p>
            <p>
                <a href="{{ route( 'register' ) }}">新規登録</a>
            </p>
    </form>
</div>
@endsection