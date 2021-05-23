@extends( 'common.layout' )

@section( 'header' )
<h1>宿を探す</h1>
@endsection

@section( 'contents' )
<div>
    <form action="{{ route( 'inn_search' ) }}" method="GET">
        @csrf
        <input  type="search" name="address" placeholder="ロケーション" value="{{ old( 'location' ) }}">
        <button type="submit">検索</button>
    </form>    
</div>

<div>
    @if( isset( $inns ) )
        @foreach( $inns as $inn )
            <div>
                <div>
                    <p>{{ $inn->name }}</p>
                    <a href="{{--{{ route( 'inns.edit', $inn ) }}--}}">詳細を見る</a>
                </div>
            </div>
        @endforeach    
    @endif
</div>
@endsection