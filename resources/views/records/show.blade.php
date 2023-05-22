@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-8 col-lg-6 offset-md-2">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between">
          <h3>{{ $record->title }}</h3>
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
        </div>
      </div>
      <div class="card-body">
        <h4 class="card-text">{{ $record->user->name }} さん</h4>
        <p class="card-text mt-3">学習日：{{ $record->learning_date }}</p>
        <p class="card-text">学習時間：{{ $hours }} 時間 {{ $minutes }} 分</p>
        <hr>
        @foreach($record->tags as $tag)
        <span class="card-text">{{ $tag->name}}</span>
        @endforeach
        <div id="post-content">
          <post-content :initial-record-body="{{ json_encode($record->body) }}"></post-content>
        </div>
        @include('records.loading')
        @if(isset($generated_text))
        <hr>
        <p class="card-text">ChatGPTによるレビュー</p>
        <p class="card-text">{{ $generated_text }}</p>
        @endif
      </div>
      <div id={{ $record->is_draft === false ? 'like-button' : '' }}>
        <record-like :record-id="@json($record->id)" :initial-is-liked="@json($record->isLikedBy(Auth::user()))"
          :initial-count-likes="@json($record->countLikes())"></record-like>
      </div>
    </div>
    @if(Auth::id() === $record->user_id && $record->is_draft === false)
    <a href="{{route('chatgpt.getReview', ['record' => $record->id])}}" class="btn btn-primary"
      onclick="showLoadingScreen()"><i class="fas fa-robot"></i>ChatGPTレビュー</a>
    @endif
  </div>
  <div class="col-md-7 col-lg-3 offset-md-1">
    <div id={{ $record->is_draft === false ? 'comment-form' : '' }}>
      <comment-form :record-id="@json($record->id)" :user-id="@json(Auth::id())">
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