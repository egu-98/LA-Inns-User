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
<div class="uk-text-center">
    <div class="uk-margin-xlarge-top uk-margin-xlarge-buttom">
        <h1>ご予約いただき</h1>
        <h1>誠にありがとうございます！</h1>
    </div>
    
    <a class="uk-button uk-button-default uk-margin-top" onclick="location.href='/'" style="border-radius: 40px">トップに戻る</a>   
</div>

@endsection