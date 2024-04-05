<body>
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title">
                お探しのページが見つかりませんでした。
                @auth
                  <a href="{{ url()->previous() }}">戻る</a>
                @endauth
                @guest
                 <a href="{{ route('login') }}">ログインページへ</a>
                @endguest
            </div>
        </div>
    </div>
</body>