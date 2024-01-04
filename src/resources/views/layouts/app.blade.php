<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!--css下記追加-->
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>
<body>
    <header>
        <div class="header_inner">
            <div class="header_logo">
                <h1>Atte</h1>
            </div>
            @yield('header')
        </div>
    </header>
    <main>
        <div class="main">
        @yield('content')
        </div>
    </main>
    <footer>
        <div class="footer_inner">
            Atte,inc.
        </div>
    </footer>
</body>
</html>