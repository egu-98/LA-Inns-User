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
<h1>予約</h1>

<div>
    <form action="{{ route( 'books.create' ) }}" method="GET" >
        @csrf
        <p>
            <label for="name">チェックイン</label>
            <input type="date" name="checkin_date">
        </p>
        <p>
            <label for="name">チェックアウト</label>
            <input type="date" name="checkout_date">
        </p>
        <p>
            <label for="plan">プラン</label>
            <select name="plan">
                @foreach( $plans as $plan )
                    <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                @endforeach
            </select>
        </p>
        <button type="submit">変更する</button>
    </form>
</div>
@endsection