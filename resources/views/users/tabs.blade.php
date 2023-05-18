<ul class="nav nav-tabs nav-justified mt-3">
  <li class="nav-item">
    <a class="nav-link text-muted {{ $hasRecords ? 'active' : '' }}"
      href="{{ route('users.showRecords', ['user' => $user]) }}">
      記事
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-muted {{ $hasLikes ? 'active' : '' }}"
      href="{{ route('users.showLikes', ['user' => $user]) }}">
      いいね
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-muted {{ $hasStudyAnalytics ? 'active' : '' }}"
      href="{{ route('users.showStudyAnalytics', ['user' => $user]) }}">
      学習記録
    </a>
  </li>
</ul>