<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config( 'app.name' ) }}</title>
</head>
<body>
    <div>
        <div>
            <img src="img/LA_Inns.jpg" alt="LA_Inns" style="width: 11ex; height: 14ex" onclick="location.href='/'">
        </div>        
        <h1>新規登録</h1>
    </div>
    
    <hr>

    <div>
        <h2>宿.comへようこそ</h2>
        @include( 'common.flash' )
        <form action="{{ route( 'register' ) }}" method="POST">
            @csrf
            <p>
                <label for="name">名前</label>
                <input type="text" name="name" value="{{ old( 'name' ) }}">
            </p>
            <p>
                <label for="email">メールアドレス</label>
                <input type="email" name="email" value="{{ old( 'email' ) }}">
            </p>
            <p>
                <label for="password">パスワード</label>
                <input type="password" name="password" value="">
            </p>
            <p>
                <label for="password_confirmation">パスワード</label>
                <input type="password" name="password_confirmation" value=""">
            </p>
            <p>
                <button type="submit">新規登録</button>
            </p>
            <p>または</p>
            <p>
                <a href="{{ route( 'login' ) }}">ログイン</a>
            </p>
        </form>
    </div>
</body>
</html>