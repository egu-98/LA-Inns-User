<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config( 'app.name' ) }}</title>
</head>
<body>
    <div>
        <div>
            <h1>宿.com</h1>
        </div>
        <div>
            @yield( 'header' )
        </div>
        <div>
            <a class="button" href="">ログイン</a>
        </div>
    </div>
    
    <hr>

    <div>
        @yield( 'contents' )
    </div>
</body>
</html>