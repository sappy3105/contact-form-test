<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionablyLate</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app_admin.css') }}">
    @yield('css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inria+Serif:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap"
        rel="stylesheet">
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header-utilities">
                <div class="header_blank"></div>
                <a class="header__logo" href="/">
                    FashionablyLate
                </a>
                <nav>
                    <ul class="header-nav">
                        @guest
                            @if (!request()->routeIs('login'))
                                <li class="header-nav__item">
                                    <a class="header-nav__link" href="/login">login</a>
                                </li>
                            @endif
                            @if (!request()->routeIs('register'))
                                <li class="header-nav__item">
                                    <a class="header-nav__link" href="/register">register</a>
                                </li>
                            @endif
                        @endguest
                        @if (Auth::check())
                            <li class="header-nav__item">
                                <form class="header-nav__form" action="/logout" method="post">
                                    @csrf
                                    <button class="header-nav__button">logout</button>
                                </form>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>
