@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-2 col-lg-2 offset-lg-1">
    @include('users.user')
  </div>
  <div class="col-md-10 col-lg-8">
    @include('users.tabs', ['hasRecords' => false, 'hasLikes' => false, 'hasStudyAnalytics' => true])
    <div id="study-analytics"></div>
  </div>
</div>
@endsection