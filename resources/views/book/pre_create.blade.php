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
<h2>{{ $inn_name }}</h2>
@if( isset( $room_error ) )
    <ul>
    @foreach ( $room_error as $re )
        <li>{{ $re }}</li>
    @endforeach
    </ul>
@endif
<div>
    <form action="{{ route( 'books.create' ) }}" method="GET" name="book_form">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user_id }}">
        <input type="hidden" name="inn_id" value="{{ $inn_id }}">
        <p>
            <label for="name">チェックイン：</label>
            <input type="date" name="checkin_date" id="checkin_date" onchange="total_price()" value="{{ request( 'checkin_date' ) }}">
        </p>
        <p>
            <label for="name">チェックアウト：</label>
            <input type="date" name="checkout_date" id="checkout_date" onchange="total_price()" value="{{ request( 'checkout_date' ) }}">
        </p>
        <p>
            <label for="plan">プラン：</label>
            <select name="plan" id="plan" onchange="total_price()">
                @foreach( $plans as $plan )
                    <option value="{{ $plan->id }}_{{ $plan->price }}" id="plan_{{ $plan->id }}" value="{{ request( 'plan' ) }}"
                        {{ request( 'plan' ) == $plan->id ? 'selected' : '' }}>{{ $plan->name }}: {{ $plan->price }}円/泊</option>
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

            // get checkin date -> date object
            var checkin_date = document.getElementById( 'checkin_date' );
            checkin_date = checkin_date.value.split( '-' ); 
            checkin_date = new Date( checkin_date[ 0 ], checkin_date[ 1 ], checkin_date[ 2 ] );
            
            console.log( checkin_date[ 0 ] );
            console.log( checkin_date[ 1 ] );
            console.log( checkin_date[ 2 ] );
            console.log( checkin_date );

            // get checkout date -> date object
            var checkout_date = document.getElementById( 'checkout_date' );
            checkout_date = checkout_date.value.split( '-' );
            checkout_date = new Date( checkout_date[ 0 ], checkout_date[ 1 ], checkout_date[ 2 ] );
            
            console.log( checkout_date );

            // calculate days
            days = ( checkout_date - checkin_date) / 86400000;
            console.log( days );

            // get price of the plan
            var plan = document.book_form.plan;
            const num = plan.selectedIndex;
            plan_price = plan.options[num].value;
            plan_price = plan.options[num].value.split( '_' )[ 1 ];

            // get the numbar of rooms
            rooms = document.getElementById( 'rooms' );
            rooms = rooms.value;

            // calculate total price to stay
            total_price = Number( plan_price ) * Number( rooms ) * Number( days );
            if( !isNaN( total_price ) ) document.getElementById( 'total_price' ).innerHTML = total_price + "円";
        }
    </script>
</div>
@endsection