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
            <label for="name">チェックイン：</label>
            <input type="date" name="checkin_date">
        </p>
        <p>
            <label for="name">チェックアウト：</label>
            <input type="date" name="checkout_date">
        </p>
        <p>
            <label for="plan">プラン：</label>
            <select name="plan">
                @foreach( $plans as $plan )
                    <option value="{{ $plan->id }}" id="plan_{{ $plan->id }}" >{{ $plan->name }}: {{ $plan->price }}円/泊</option>
                @endforeach
            </select>
        </p>
        <p>
            <label for="rooms" id="rooms">部屋数：</label>
            <input type="text" name="rooms" style="width: 5em">部屋
        </p>

        <hr>

        <div>
            料金：<span id="total_price"></span>
            <script>
                
            </script>
        </div>
        
        <button type="submit">予約する</button>
    </form>
</div>
@endsection