@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
  <div class="col-sm-12 col-md-11 col-lg-10">
    <h1 class="mb-4">下書き一覧</h1>
    <table class="table table-borderless">
      <tbody>
        @foreach ($user->myDrafts as $draft)
        <tr class="h5">
          <td>
            {{ $draft->learning_date }}
          </td>
          <td>学習時間{{ $draft->duration }} 分</td>
        </tr>
        <tr>
          <td class="h3"><a href="{{ route('records.show', ['record' => $draft->id]) }}">
              {{ $draft->title }}
          </td>
        </tr>
        <tr>
          <td>
            {{ $draft->body }}
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection