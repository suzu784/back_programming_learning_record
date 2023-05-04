<div class="card d-flex flex-column align-items-center mt-3">
  <div class="card-body">
    <div class="d-flex flex-column">
      <a href="{{ route('users.showRecords', ['user' => $user]) }}" class="text-dark">
        <i class="fas fa-user-circle fa-3x"></i>
      </a>
    </div>
    <h2 class="h5 card-title m-0">
      <a href="{{ route('users.showRecords', ['user' => $user]) }}" class="text-dark">
        {{ $user->name }}
      </a>
    </h2>
    <hr>
    <h5 class="card-subtitle mb-2 text-muted">目標</h5>
    <p class="card-text h5 text-wrap">{{ $user->goal }}</p>
    @if(auth()->id() == $user->id)
    <div id="goal-form"></div>
    @endif
  </div>
</div>