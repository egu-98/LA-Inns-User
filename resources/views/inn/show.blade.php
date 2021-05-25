@extends( 'common.layout' )

@section( 'header' )
<form action="{{ route( 'inn_search' ) }}" method="GET">
    @csrf
    <input  type="search" name="address" placeholder="ロケーション" value="{{ old( 'location' ) }}" >
    <button type="submit">検索</button>
</form>
@endsection

@section( 'contents' )
<h1>{{ $inn->name }}</h1>

<div>
    <img src="{{ asset( 'img/inn_pic.jpeg' ) }}" alt="{{ $inn->name }}_pics" style="width: 45ex; height: 30ex;">
</div>

<div>
    <h2>プラン一覧</h2>
    @if( isset( $plans) )
        <ul>
        @foreach ( $plans as $plan )
            <li>{{ $plan->name }}: {{ $plan->price }}円/泊</li>    
        @endforeach
        </ul>
    @endif

    @if( Auth::check() )
        <form action="{{ route( 'pre_create_book' ) }}" method="GET">
            @csrf    
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="inn_id" value="{{ $inn->id }}">
            <button type="submmit">予約する</button>        
        </form>
    @else <p>予約をするにはログインしてください</p>
    @endif
</div>

<div>
    <h2>みんなのレビュー</h2>
    @if( count( $reviews ) > 0 )
        @foreach ( $reviews as $review )
            <div>
                <img src="{{ asset( 'img/icon.jpg' ) }}" alt="{{ $review->user->name }}" style="width: 4ex; heghit: 5ex;">
                {{ $review->user->name }}
                @for ($i = 0; $i < $review->stars; $i++)
                    <img src="{{ asset( 'img/star_selected.png' ) }}" alt="star" style="width: 20px">
                @endfor
                @for ($i = 0; $i < 5-$review->stars; $i++)
                    <img src="{{ asset( 'img/star_select.png' ) }}" alt="star" style="width: 20px">
                @endfor
                <div>
                    {{ $review->text }}
                </div>
            </div>
        @endforeach
    @elseif( count( $reviews ) == 0 )
        <div>
            レビューはありません
        </div>
    @endif
    
    <div>
        @if( Auth::check() )
            @if( Auth::user()->review()->exists() )
            <p>
                <form action="{{ route( 'reviews.update', Auth::user()->review()->first() ) }}" method="POST">
                @csrf
                @method( 'put' )
                <img src="{{ asset( 'img/icon.jpg' ) }}" alt="{{ Auth::user()->name }}" style="width: 3ex; heghit: 3ex;">
                <label for="review">{{ Auth::user()->name }}</label>
                <span class="star-rating">
                    @for( $i = 1; $i <= 5; $i++ )
                        @if( $i == Auth::user()->review()->first()[ 'stars' ] )
                            <input type="radio" name="rating" value="$i" checked="checked"><i></i>  
                        @endif
                        <input type="radio" name="rating" value="{{ $i }}"><i></i>
                    @endfor>
                </span>
            </p>
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="inn_id" value="{{ $inn->id }}">
            <textarea name="review" rows="4" cols="70">{{ Auth::user()->review()->first()['text'] }}</textarea>
            <button type="submit" id="post_review">レビューを投稿する</button>
                
            @else
            <form action="{{ route( 'reviews.store' ) }}" method="POST">
                @csrf
                <p>
                    <img src="{{ asset( 'img/icon.jpg' ) }}" alt="{{ Auth::user()->name }}" style="width: 3ex; heghit: 3ex;">
                    <label for="review">{{ Auth::user()->name }}</label>
                    <span class="star-rating">
                        <input type="radio" name="rating" value="1"><i></i>
                        <input type="radio" name="rating" value="2"><i></i>
                        <input type="radio" name="rating" value="3"><i></i>
                        <input type="radio" name="rating" value="4"><i></i>
                        <input type="radio" name="rating" value="5"><i></i>
                    </span>
                </p>
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <input type="hidden" name="inn_id" value="{{ $inn->id }}">
                <textarea name="review" rows="4" cols="70"></textarea>
                <button type="submit" id="post_review">レビューを投稿する</button>
            </form>
            @endif  
        @endif
    </div>
</div>

<div>
    <iframe src="https://www.google.com/maps?output=embed&z=15&q={{ $inn->address }}" width="500" height="350" frameborder="0" style="border: 0;" aria-hidden="false" tabindex="0"></iframe>
</div>

@endsection