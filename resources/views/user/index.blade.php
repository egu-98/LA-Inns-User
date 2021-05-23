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
<div>
    <img src="img/icon.jpg" alt="user_icon" style="width: 20ex; heghit: 20ex">
    <h3>名前： {{ $user->name }}</h3>
    <p>メールアドレス： {{ $user->email }}</p>
    <a href="{{ route( 'users.edit', $user->id ) }}">アカウント情報を変更する</a>
</div>

<div>
<h2>予約履歴</h2>
@if( isset( $books ) )
<ul>
    @foreach ( $books as $book )
    <li>
        予約
    </li>
    @endforeach
</ul>
@endif
</div>
@endsection