<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SimpleNote') }}</title>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="main">
        @if(session('success'))
            <div class="alert alert-success" role="alert">
              {{ session('success') }}
            </div>
        @endif
          <div class="row" style='height: 92vh;'>
            <div class="col-md-2 p-0">
              <div class="card h-100">
              <div class="card-header">タグ一覧</div>
              <div class="card-body py-2 px-4">
                <a class='d-block' href='/'>全て表示</a>
                @foreach ($tags as $tag)
                    <a href="/?tag={{ $tag['name'] }}" class="d-block">{{ $tag['name'] }}</a>
                @endforeach                  
                </div>
              </div>
            </div>
            <div class="col-md-4 p-0">
              <div class="card h-100">
                <div class="card-header d-flex justify-content-between">メモ一覧 <a class='ml-auto' href='/create'><i class="fas fa-plus-circle"></i></a></div>
                <div class="card-body p-2">
                    @foreach ($memos as $memo)
                        <a href="/edit/{{ $memo['id'] }}" class="d-block">{{ $memo['content'] }}</a>
                    @endforeach 
                    <br>                   
                    <div class="show-deleted-memo">削除したメモ一覧を表示する</div>
                    <div class="deleted-memo-content pt-2">
                        @if (!$deleted_memos->isEmpty())
                            @foreach ($deleted_memos as $deleted_memo)
                                <form method="POST" action="/restore/{{ $deleted_memo['id'] }}" id="restore-form" class="mb-2">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                    <div class="w-100 d-flex justify-content-between align-items-center">
                                        <span class="d-block">{{ $deleted_memo['content'] }}</span>
                                        <button type="subimt" class="restore-btn btn btn-outline-primary btn-sm">元に戻す</button>
                                    </div>
                                </form>
                            @endforeach
                        @else
                            <p>※削除されたものはありません</p>
                        @endif
                    </div>
                </div>
              </div>    
            </div> <!-- col-md-3 -->
            <div class="col-md-6 p-0">
              @yield('content')
            </div>
          </div> <!-- row justify-content-center -->
        </main>
    </div>
    @yield('footer')
</body>
</html>