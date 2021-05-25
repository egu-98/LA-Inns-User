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
<a  class="uk-margin-small-left" uk-icon="icon: arrow-left; ratio: 2" href="{{ route( 'users.index' ) }}"></a>
<div class="uk-text-center">
    <h1>アカウント情報変更</h1>

    <div>
        <img src="{{ asset( 'img/icon.jpg' ) }}" alt="user_icon" style="width: 20ex; heghit: 20ex">
    </div>
    <div>
        <form action="{{ route( 'users.update', $user->id ) }}" method="POST" >
            @csrf
            @method( 'put' )
            <p>
                <label for="name">名前：</label>
                <input type="text" name="name" placeholder="{{ $user->name }}" value="{{ $user->name }}">
            </p>
            <p>
                <label for="email">メールアドレス：</label>
                <input type="email" name="email" placeholder="{{ $user->email }}" value="{{ $user->email }}">
            </p>
            <button class="uk-button uk-button-default uk-margin-small-bottom" type="submit">変更する</button>
        </form>
    </div>
</div>
@endsection