@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-2 col-lg-2 offset-lg-1">
    @include('users.user')
  </div>
  <div class="col-md-10 col-lg-8">
    @include('users.tabs', ['hasRecords' => false, 'hasLikes' => true, 'hasStudyAnalytics' => false])
    @include('records.learning_record', ['hasRecords' => false, 'hasLikes' => true])
  </div>
</div>
@endsection