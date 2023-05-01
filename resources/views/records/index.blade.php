@extends('layouts.app')
@section('content')
@if(isset($message))
<p>{{ $message }}</p>
@else
<div class="row justify-content-center">
  <div class="col-sm-12 col-md-11 col-lg-10">
    <h1 class="mb-4">学習記録一覧</h1>
    <table class="table table-borderless">
      <tbody>
        @foreach ($records as $record)
        <tr class="h5">
          <td>
            {{ $record->learning_date }}
            {{ $record->user->name }} さん
          </td>
          <td>学習時間{{ $record->duration }} 分</td>
        </tr>
        <tr>
          <td class="h3"><a href="{{ route('records.show', ['record' => $record->id]) }}">
              {{ $record->title }}
          </td>
        </tr>
        <tr>
          <td>
            {{ $record->body }}
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endif
@endsection