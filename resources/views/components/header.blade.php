<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" style="min-height: 130px;">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            ブログアプリ
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item d-flex">
                    <a class="nav-link" href="{{ route('top') }}">学習記録一覧</a>
                    @guest
                    <a class="nav-link" href="{{ route('login') }}">ログイン</a>
                    <a class="nav-link" href="{{ route('register') }}">新規登録</a>
                    @else
                    <a class="nav-link" href="{{ route('records.create') }}">学習を記録</a>
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                        ログアウト
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    @endguest
                </li>
            </ul>
        </div>
    </div>
</nav>