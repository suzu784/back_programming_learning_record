@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-2 col-lg-2">
    @include('users.user')
  </div>
  <div class="col-md-10 col-lg-9">
    @include('users.tabs', ['hasRecords' => false, 'hasLikes' => true])
  </div>
</div>
@endsection