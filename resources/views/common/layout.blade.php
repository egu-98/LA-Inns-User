<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config( 'app.name' ) }}</title>

    <link rel="stylesheet" href="{{ asset( 'css/layout.css' ) }}">
</head>
<body>
    <div>
        <div>
            <img src="{{ asset( 'img/LA_Inns.jpg' ) }}" alt="LA_Inns" style="width: 11ex; height: 14ex" onclick="location.href='/'">
        </div>
        <div>
            @yield( 'header' )
        </div>
        <div>
            @if( Auth::check() )
                <ul class="navigation">
                    <li>
                        <a href="{{ route( 'users.index' ) }}">アカウント</a>
                    </li>
                    <li>
                        <a href="" onclick="logout()">ログアウト</a>
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
                    </li>
                </ul>
            @else
                <a class="button" href="{{ route( 'login' ) }}">ログイン</a>
            @endif
        </div>
    </div>
    
    <hr>

    <div>
        @yield( 'contents' )
    </div>
</body>
</html>