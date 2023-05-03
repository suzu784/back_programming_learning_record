<div class="row justify-content-center">
  <div class="col-md-10 col-lg-9">
    <div class="card mt-3">
      <div class="card-body">
        <div class="d-flex flex-row">
          <a href="{{ route('users.show', ['user' => $user]) }}" class="text-dark">
            <i class="fas fa-user-circle fa-3x"></i>
          </a>
        </div>
        <h2 class="h5 card-title m-0">
          <a href="{{ route('users.show', ['user' => $user]) }}" class="text-dark">
            {{ $user->name }}
          </a>
        </h2>
      </div>
    </div>
  </div>
</div>