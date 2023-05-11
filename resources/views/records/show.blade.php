@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-9 col-lg-8">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between">
          <span>{{ $record->title }}</span>
          <div>
            <a href="{{ route('records.edit', $record->id) }}" class="btn btn-success"><i class="fas fa-edit"></i></a>
            <form action="{{ route('records.destroy', $record->id) }}" method="POST" style="display:inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除しますか？');"><i
                  class="fas fa-trash"></i></button>
            </form>
          </div>
        </div>
      </div>
      <div class="card-body">
        <p class="card-text">
          {{ $record->learning_date }}
          {{ $record->user->name }} さん
        </p>
        <p class="card-text">学習時間：{{ $hours }} 時間 {{ $minutes }} 分</p>
        <p class="card-text">{{ $record->body }}</p>
        @if(Auth::id() === $record->user_id)
        <div class="mt-3">
          <a href="{{route('chatgpt.getReview', ['record' => $record->id])}}" class="btn btn-primary"
            onclick="if('{{ e($generated_text) }}') return confirm('レビューを更新しますか？');"><i
              class="fas fa-robot"></i>ChatGPTレビュー</a>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@if(isset($generated_text))
<div class="row mt-5">
  <div class="col-md-5 offset-md-2">
    <div class="card">
      <div class="card-header">
        <h1 class="card-title">ChatGPTによるレビュー</h1>
      </div>
      <div class="card-body">
        <p class="card-text">{{ $generated_text }}</p>
      </div>
    </div>
  </div>
</div>
@endif
@endsection