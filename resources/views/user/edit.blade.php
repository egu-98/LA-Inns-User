@extends( 'common.layout' )

@section( 'header' )
<div>
    <form action="{{ route( 'inn_search' ) }}" method="GET">
        @csrf
        <input  type="search" name="address" placeholder="ロケーション" value="{{ old( 'location' ) }}">
        <button type="submit">検索</button>
    </form>    
</div>
@endsection

@section( 'contents' )
<h1>アカウント情報変更</h1>

<div>
    <img src="img/icon.jpg" alt="user_icon" style="width: 20ex; heghit: 20ex">
</div>
<div>
    <form action="{{ route( 'users.update', $user->id ) }}" method="POST" >
        @csrf
        @method( 'put' )
        <p>
            <label for="name">名前</label>
            <input type="text" name="name" placeholder="{{ $user->name }}" value="{{ $user->name }}">
        </p>
        <p>
            <label for="email">メールアドレス</label>
            <input type="email" name="email" placeholder="{{ $user->email }}" value="{{ $user->email }}">
        </p>
        {{-- <p>
            <label for="password">パスワード</label>
            <input type="password" name="password">
        </p> --}}
        <button type="submit">変更する</button>
    </form>
</div>
@endsection