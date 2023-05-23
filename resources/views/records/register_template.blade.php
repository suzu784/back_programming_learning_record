@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
  <div class="col-sm-10 col-md-9 col-lg-8">
    <h3>テンプレート登録画面</h3>
    <form action="{{ route('templates.store') }}" method="POST">
      @csrf
      <div class="form-group mt-4">
        <label for="name">タイトル</label>
        <input type="text" name="name" class="form-control" id="name" />
      </div>
      <div class="form-group mt-4">
        <label for="content">本文</label>
        <textarea name="content" cols="40" rows="18" class="form-control" id="content"></textarea>
      </div>
      <div class="form-group mt-3">
        <button type="submit" class="btn btn-primary">登録</button>
      </div>
    </form>
  </div>
</div>
</div>
@endsection