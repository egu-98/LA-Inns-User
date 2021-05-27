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
<a  class="uk-margin-small-left" uk-icon="icon: arrow-left; ratio: 2" href="{{ route( 'users.index' ) }}"></a>
<div class="uk-text-center">

    <h1>予約情報確認</h1>

    <div>
        <h2>{{ $inn->name }}</h2>
        <form action="" method="POST">
            @csrf
            <input type="hidden" name="user_id" value="{{ $book->user_id }}">
            <input type="hidden" name="inn_id" value="{{ $book->inn_id }}">
            <input type="hidden" name="plan_id" value="{{ $book->plan_id }}">
            <p>
                チェックイン：{{ $checkin_date }}
                <input type="hidden" name="checkin_date" value="{{ $book->checkin_date }}" id="checkin_date">
            </p>
            <p>
                チェックアウト：{{ $checkout_date }}
                <input type="hidden" name="checkout_date" value="{{ $book->checkout_date }}" id="checkout_date">
            </p>
            <p>
                プラン：{{ $plan->name }}
                <input type="hidden" name="plan" value="{{ $plan->id }}_{{ $plan->price }}" id="plan">
            </p>
            <p>
                部屋数：{{ $book->rooms }}部屋
                <input type="hidden" name="rooms" value="{{ $book->rooms }}" id="rooms">
            </p>

            <hr>

            <div class="uk-text-bolder uk-text-large uk-margin-bottom">
                料金：<span id="total_price"></span>
            </div>
        </form>
        @if( $book->checkin_date >= date('Y-m-d') )    
            <a href="" onclick="deleteBook({{ $book->id }})" >キャンセルする</a>
            <form action="{{ route( 'books.destroy', $book->id ) }}" method="POST" id="delete-form">
                @csrf
                @method( 'delete' )
            </form>
        @endif
        <script>
            var total_price;
            var days;
            var plan_price;
            var rooms;

            // get checkin date -> date object
            var checkin_date = document.getElementById( 'checkin_date' );
            checkin_date = checkin_date.value.split( '-' ); 
            checkin_date = new Date( checkin_date[ 0 ], checkin_date[ 1 ], checkin_date[ 2 ] );

            // get checkout date -> date object
            var checkout_date = document.getElementById( 'checkout_date' );
            checkout_date = checkout_date.value.split( '-' );
            checkout_date = new Date( checkout_date[ 0 ], checkout_date[ 1 ], checkout_date[ 2 ] );
            
            // calculate days
            days = ( checkout_date - checkin_date) / 86400000;

            // get price of the plan
            var plan = document.getElementById( 'plan' );
            plan_price = plan.value.split( '_' )[ 1 ];

            // get the numbar of rooms
            rooms = document.getElementById( 'rooms' );
            rooms = rooms.value;

            // calculate total price to stay
            total_price = Number( plan_price ) * Number( rooms ) * Number( days );
            if( !isNaN( total_price ) ) document.getElementById( 'total_price' ).innerHTML = total_price + "円";

            function deleteBook(id){
                event.preventDefault();
                if( window.confirm( '本当に削除しますか？' ) ){
                    document.getElementById( "delete-form" ).submit();
                }
            }
        </script>
    </div>
</div>
@endsection