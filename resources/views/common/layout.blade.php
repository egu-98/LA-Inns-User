<!DOCTYPE html>
<html lang="ja" style="background-color: #f5f5f5">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config( 'app.name' ) }}</title>

    <link rel="stylesheet" href="{{ asset( 'css/layout.css' ) }}">
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.6.22/dist/css/uikit.min.css" />

    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.6.22/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.6.22/dist/js/uikit-icons.min.js"></script>
</head>
<body>
    <div style="background-color: #5b4c64">
        <div class="uk-margin-remove-bottom uk-child-width-expand@s" uk-grid>
            <div>
                {{-- <img src="{{ asset( 'img/LA_Inns.jpg' ) }}" alt="LA_Inns" style="width: 10ex; height: 13ex" onclick="location.href='/'"> --}}
                <a class="uk-margin-left uk-margin-remove-bottom" onclick="location.href='/'" style="font-size: 50px; color: white; text-decoration: none;">L</a>
                <p class="uk-margin-small-left uk-margin-remove-top" style="color: white;">LA-Inns</p>
            </div>

            @yield( 'header' )
            
            <div class="uk-text-right uk-margin-small-right uk-margin-top">
                @if( Auth::check() )
                <div class="uk-inline">
                    <button class="uk-button uk-button-default" type="button" style="color: white">アカウント</button>
                    <div uk-dropdown="mode: click" class="uk-text-left">
                        <p>
                            <a href="{{ route( 'users.index' ) }}">アカウント情報</a>
                        </p>
                        <p>
                            <a href="" onclick="logout()">ログアウト</a>
                        </p>
                    </div>
                    <form action="{{ route( 'logout' ) }}" method="POST" id="logout-form">
                        @csrf
                   </form>
                   <script type="text/javascript">
                       function logout(){
                           event.preventDefault();
                           if( window.confirm( 'ログアウトしますか？' ) ){
                               document.getElementById( 'logout-form' ).submit();
                           }
                       }
                   </script>
                </div>    
                @else
                    <a class="uk-button uk-button-default" type="button" href="{{ route( 'login' ) }}" style="color: white">ログイン</a>
                @endif
            </div>
        </div>
    </div>
  
    <hr class="uk-margin-remove-top">

    <div>
        @yield( 'contents' )
    </div>
</body>
</html>