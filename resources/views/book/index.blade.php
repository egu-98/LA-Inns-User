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
<h1>予約情報入力</h1>

<div>
    <form action="{{ route( 'books.create' ) }}" method="GET" name="book_form">
        @csrf
        <p>
            <label for="name">チェックイン：</label>
            <input type="date" name="checkin_date" id="checkin_date" onchange="total_price()">
        </p>
        <p>
            <label for="name">チェックアウト：</label>
            <input type="date" name="checkout_date" id="checkout_date" onchange="total_price()">
        </p>
        <p>
            <label for="plan">プラン：</label>
            <select name="plan" id="plan" onchange="total_price()">
                @foreach( $plans as $plan )
                    <option value="{{ $plan->id }}_{{ $plan->price }}" id="plan_{{ $plan->id }}" >{{ $plan->name }}: {{ $plan->price }}円/泊</option>
                @endforeach
            </select>
        </p>
        <p>
            <label for="rooms" >部屋数：</label>
            <input type="text" name="rooms" id="rooms" style="width: 5em" value="" oninput="total_price()">部屋
        </p>

        <hr>

        <div>
            料金：<span id="total_price"></span>
        </div>
        <button type="submit">予約する</button>
    </form>
    <script>
        function total_price(){        
            var total_price;
            var days;
            var plan_price;
            var rooms;

            // checkin_date = new Date( document.getElementById( 'checkin_date' ) );
            checkin_date = document.getElementById( 'checkin_date' );
            checkin_date = checkin_date.value.split( '-' );
            console.log( checkin_date[ 0 ] );
            console.log( checkin_date[ 1 ] );
            console.log( checkin_date[ 2 ] );
            
            var checkin_date = new Date( checkin_date[ 0 ], checkin_date[ 1 ], checkin_date[ 2 ] );
            console.log( checkin_date );

            // checkout_date = new Date( document.getElementById( 'checkout_date' ) );
            checkout_date = document.getElementById( 'checkout_date' );
            checkout_date = checkout_date.value.split( '-' );
            var checkout_date = new Date( checkout_date[ 0 ], checkout_date[ 1 ], checkout_date[ 2 ] );
            console.log( checkout_date );
            
            days = ( checkout_date - checkin_date) / 86400000;
            console.log( days );

            var plan = document.book_form.plan;
            const num = plan.selectedIndex;
            plan_price = plan.options[num].value;
            plan_price = plan.options[num].value.split( '_' )[ 1 ];

            rooms = document.getElementById( 'rooms' );
            rooms = rooms.value;

            total_price = Number( plan_price ) * Number( rooms ) * Number( days );
            if( !isNaN( total_price ) ) document.getElementById( 'total_price' ).innerHTML = total_price + "円";
        }
    </script>
</div>
@endsection