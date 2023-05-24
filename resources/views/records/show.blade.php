@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-8 col-lg-6 offset-md-2">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between">
          <h3>{{ $record->title }}</h3>
          @if(Auth::id() === $record->user_id)
          <div>
            <a href="{{ route('records.edit', $record->id) }}" class="btn btn-success"><i class="fas fa-edit"></i></a>
            <form action="{{ route('records.destroy', $record->id) }}" method="POST" style="display:inline">
              @csrf
              @method('DELETE')
              @foreach($record->tags as $tag)
              <input type="hidden" name="tagId" value="{{ $tag->id}}">
              @endforeach
              <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除しますか？');"><i
                  class="fas fa-trash"></i></button>
            </form>
          </div>
          @endif
        </div>
      </div>
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div>
            @foreach($record->tags as $tag)
            <span class="card-text tag-name">{{ $tag->name}}</span>
            @endforeach
          </div>
          <div>
            <span class="card-text mt-3">学習日：{{ $record->learning_date }}</span>
            <p class="card-text">学習時間：{{ $hours }} 時間 {{ $minutes }} 分</p>
          </div>
        </div>
        <hr>
        <a href="{{ route('users.showRecords', ['user' => $record->user->id])}}" class="card-text h5">{{
          $record->user->name }}</a><span class="h5">さんの投稿&ensp;({{ substr($record->created_at, 0, 10) }})</span>
        <div id="post-content">
          <post-content :initial-record-body="{{ json_encode($record->body) }}"></post-content>
        </div>
        @include('records.loading')
        @if(isset($generated_text))
        <h5 class="card-text mt-5 text-danger"><i class="fas fa-robot"></i>&nbsp;ChatGPTレビュー</h5>
        <p class="card-text mt-4">{{ $generated_text }}</p>
        @endif
      </div>
    </div>
    <div class="d-flex justify-content-start mt-2">
      @if(Auth::id() === $record->user_id && $record->is_draft === false)
      <a href="{{route('chatgpt.getReview', ['record' => $record->id])}}" class="btn btn-primary"
        onclick="showLoadingScreen()"><i class="fas fa-robot"></i>ChatGPTレビュー</a>
      @endif
      <div id={{ $record->is_draft === false ? 'like-button' : '' }}>
        <record-like :record-id="@json($record->id)" :initial-is-liked="@json($record->isLikedBy(Auth::user()))"
          :initial-count-likes="@json($record->countLikes())" :authorized="@json(Auth::check())"></record-like>
      </div>
    </div>
  </div>
  <div class="col-md-7 col-lg-3 offset-md-1">
    <div id={{ $record->is_draft === false ? 'comment-form' : '' }}>
      <comment-form :record-id="@json($record->id)" :user-id="@json(Auth::id())" :authorized="@json(Auth::check())">
      </comment-form>
    </div>
  </div>
</div>
@endsection

<script>
  function showLoadingScreen() {
  // ローディング画面を表示
  const loadingOverlay = document.querySelector(".loading-overlay");
  loadingOverlay.classList.add("show");
  }
</script>