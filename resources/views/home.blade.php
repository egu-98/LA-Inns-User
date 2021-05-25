@extends( 'common.layout' )

@section( 'header' )
<h1 class="uk-text-center uk-margin-top">宿を探す</h1>
@endsection

@section( 'contents' )
<div class="uk-text-center uk-margin-bottom">
    <form class="uk-search uk-search-large" action="{{ route( 'inn_search' ) }}" method="GET" style="border: 1px solid; boder-color: gray; border-radius: 20px;">
        @csrf
        <input class="uk-search-input" type="search" name="address" placeholder="ロケーション" value="{{ request( 'location' ) }}">
        <button class="uk-search-icon-flip" type="submit" uk-search-icon></button>
    </form>    
</div>


<div class="uk-margin-xlarge-left uk-margin-xlarge-right">
@if( isset( $inns ) )
    @foreach( $inns as $inn )
        <div class="uk-card uk-card-default uk-card-body uk-margin-bottom">
            <div class="uk-flex">
                <div class="uk-container uk-margin-remove">
                    <img src="{{ asset( 'img/inn_pic.jpeg' ) }}" alt="{{ $inn->name }}_pic" class="uk-width-medium">
                </div>
                <div class="uk-container uk-margin-remove">
                    <h2>{{ $inn->name }}</h2>
                    <p>{{ $inn->address }}</p>
                    <a href="{{ route( 'inns.show', $inn ) }}">詳細を見る</a>
                </div>
            </div>
        </div>
    @endforeach    
@endif
</div>

@endsection