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
<a  class="uk-margin-small-left" uk-icon="icon: arrow-left; ratio: 2" href="{{ route( 'user_home' ) }}"></a>
<h1 class="uk-text-center uk-margin-medium-top uk-margin-medium-bottom">{{ $inn->name }}</h1>

<div class="uk-flex">
    <div class="uk-container uk-margin-remove-right">
        <img src="data:image/png;base64,{{ $inn->pic_path }}" alt="{{ $inn->name }}_pics" style="width: 45ex; height: 30ex; border-radius: 20px;">
    </div>
    
    <div class="uk-container">
        <h2 class="uk-heading-bullet">プラン一覧</h2>
        @if( isset( $plans) )
            <ul class="uk-list uk-list-divider uk-list uk-list-circle">
            @foreach ( $plans as $plan )
                <li>
                    {{ $plan->name }}: {{ $plan->price }}円/泊
                    <p>【プラン内容】{{ $plan->content }}</p>
                </li>    
            @endforeach
            </ul>
        @endif
    
        @if( Auth::check() )
            <form action="{{ route( 'pre_create_book' ) }}" method="GET">
                @csrf    
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <input type="hidden" name="inn_id" value="{{ $inn->id }}">
                <button class="uk-button uk-button-default" type="submit" id="reserve">予約する</button>        
            </form>
        @else <a class="uk-button uk-button-default" href="{{ route( 'login' ) }}">予約をするにはログインしてください</a>
        @endif
    </div>
</div>

<div class="uk-margin-large-top uk-margin-left">
    <h2 class="uk-heading-line"><span>みんなのレビュー</span></h2>
    <div class="review">
        @if( count( $reviews ) > 0 )
        @foreach( $reviews as $review )
            <div class=" uk-margin-bottom">
                <img src="{{ asset( 'img/icon.jpg' ) }}" alt="{{ $review->user->name }}" style="width: 4ex; heghit: 5ex;">
                {{ $review->user->name }}
                @for ($i = 0; $i < $review->stars; $i++)
                    <img src="{{ asset( 'img/star_selected.png' ) }}" alt="star" style="width: 20px">
                @endfor
                @for ($i = 0; $i < 5-$review->stars; $i++)
                    <img src="{{ asset( 'img/star_select.png' ) }}" alt="star" style="width: 20px">
                @endfor
                <div class="uk-margin-small-top">
                    {{ $review->text }}
                </div>
                <hr width="40%">
            </div>
        @endforeach
        @elseif( count( $reviews ) == 0 )
            <div class="uk-margin-bottom">
            レビューはありません
            </div>
        @endif
    </div>
    
    <div>
        @if( Auth::check() )
            @if( Auth::user()->review()->where( 'inn_id', $inn->id )->exists() )
            <div class="uk-width-2-3" style="border: 1px solid; border-radius: 30px">
                <form class="uk-margin-left" id="review-form" action="{{ route( 'reviews.update', Auth::user()->review()->where( 'inn_id', $inn->id )->first() ) }}" method="POST">
                    @csrf
                    @method( 'put' )
                    <p>
                        <img src="{{ asset( 'img/icon.jpg' ) }}" alt="{{ Auth::user()->name }}" style="width: 5ex; heghit: 5ex;">
                        <label class="uk-text-bold" for="review">{{ Auth::user()->name }}</label>
                        <span class="star-rating">
                            @for( $i = 1; $i <= 5; $i++ )
                                @if( $i == Auth::user()->review()->where( 'inn_id', $inn->id )->first()[ 'stars' ] )
                                    <input type="radio" name="rating" value="{{ $i }}" checked="checked"><i></i>  
                                @else <input type="radio" name="rating" value="{{ $i }}"><i></i>
                                @endif
                            @endfor
                        </span>
                    </p>
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="inn_id" value="{{ $inn->id }}">
                    <textarea name="review" rows="4" cols="70">{{ Auth::user()->review()->where( 'inn_id', $inn->id )->first()[ 'text' ] }}</textarea>
                    {{-- <button class="uk-button uk-button-default uk-margin-small-bottom" type="submit" id="post_review">レビューを投稿する</button> --}}
                    <button class="uk-button uk-button-default uk-margin-small-bottom" id="post_review" type="button">レビューを投稿する</button>
                </form>      
            </div>
          
            @else
            <div class="uk-width-2-3" style="border: 1px solid; border-radius: 30px">
                <form class="uk-margin-left" id="review-form" action="{{ route( 'reviews.store' ) }}" method="POST">
                    @csrf
                    <p>
                        <img src="{{ asset( 'img/icon.jpg' ) }}" alt="{{ Auth::user()->name }}" style="width: 5ex; heghit: 5ex;">
                        <label class="uk-text-bold" for="review">{{ Auth::user()->name }}</label>
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
                    {{-- <button class="uk-button uk-button-default uk-margin-small-bottom" type="submit" id="post_review">レビューを投稿する</button> --}}
                    <button class="uk-button uk-button-default uk-margin-small-bottom" id="post_review" type="button">レビューを投稿する</button>
                </form>
            </div>
            @endif  
        @endif
    </div>
    <script>
        var button = document.getElementById( 'post_review' );
        button.addEventListener( 'click', function(){
            var element = document.getElementById( 'review-form' );
            var radioNodeList = element.rating;
            var stars = radioNodeList.value;

            if ( stars != "" ) element.submit();
            else window.alert( '星評価を入力してください。' );
        })
    </script>
</div>

<div id="map-parent" class="uk-margin-top uk-text-center">
    <h2 class="uk-heading-line uk-text-center uk-margin-large-top"><span>エリア情報</span></h2>

    <div id="floating-panel">
        <input id="address" type="hidden" value="{{ $inn->address }}" />
    </div>
    <div id="map"></div>

    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBn9i52LZLE7OxAxyfpGQCM-LZAI5kyL60&callback=initMap&libraries=&v=weekly" async></script>
    <script src="{{ asset('/js/map.js') }}"></script>

</div>

@endsection