<div class="row justify-content-center">
  <div class="col-md-10 col-lg-9">
    <ul class="nav nav-tabs nav-justified mt-3">
      <li class="nav-item">
        <a class="nav-link text-muted {{ $hasRecords ? 'active' : '' }}"
          href="{{ route('users.show', ['user' => $user]) }}">
          記事
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-muted {{ $hasLikes ? 'active' : '' }}"
          href="{{ route('users.likes', ['user' => $user]) }}">
          いいね
        </a>
      </li>
    </ul>
  </div>
</div>