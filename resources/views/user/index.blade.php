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
<div class="uk-child-width-expand@s" uk-grid>
    <div>
        <div class="uk-margin-xlarge-left">
            <div class="uk-margin-xlarge-left uk-text-center uk-width-3-5 uk-padding" style="border: 1px solid; border-radius: 50px;">
                <img src="{{ asset( 'img/icon.jpg' ) }}" alt="user_icon" style="width: 20ex; heghit: 20ex">
                <h3>名前： {{ $user->name }}</h3>
                <p class="uk-text-small">メールアドレス： {{ $user->email }}</p>
                <a href="{{ route( 'users.edit', $user->id ) }}">アカウント情報を変更する</a>
            </div>
        </div>
    </div>
    
    <div>
    <h2>予約履歴</h2>
    @if( count( $books ) > 0)
        <ul class="uk-list uk-list-circle">
            @for( $i = 0; $i < count( $books ); $i++ )
            <li>
                <a href="{{ route( 'books.show', $books[ $i ]->id ) }}">{{ $inn_names[ $i ] }} ({{ $books[ $i ]->checkin_date }})</a>
            </li>
            @endfor
        </ul>
    @else
        <p>予約はありません</p>
    @endif
    </div>    
</div>
@endsection