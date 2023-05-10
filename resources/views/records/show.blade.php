@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
  <div class="col-md-9 col-lg-8">
    <div class="card">
      <div class="card-header">{{ $record->title }}</div>
      <div class="card-body">
        <p class="card-text">
          {{ $record->learning_date }}
          {{ $record->user->name }} さん
        </p>
        <p class="card-text">学習時間：{{ $hours }} 時間 {{ $minutes }} 分</p>
        <p class="card-text">{{ $record->body }}</p>
        <a href="{{ route('records.edit', $record->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i> 編集</a>
        <form action="{{ route('records.destroy', $record->id) }}" method="POST" style="display:inline">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除しますか？');"><i
              class="fas fa-trash"></i> 削除</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection