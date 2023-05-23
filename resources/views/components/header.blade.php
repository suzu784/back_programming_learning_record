<nav class="navbar navbar-expand-lg navbar-light bg-info fixed-top" id="navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}" id="navar-brand">
            ブログアプリ
        </a>
        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('top') }}">学習記録一覧</a>
                </li>
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">ログイン</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">新規登録</a>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.myDrafts', ['user' => Auth::user()]) }}">下書き一覧</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('records.create') }}">学習を記録</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.showRecords', ['user' => Auth::user()]) }}">マイページ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                        ログアウト
                    </a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                @endguest
            </ul>
        </div>
    </div>
</nav>