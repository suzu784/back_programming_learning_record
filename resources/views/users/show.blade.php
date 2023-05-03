@extends('layouts.app')
@section('content')
@include('users.user')
@include('users.tabs', ['hasRecords' => true, 'hasLikes' => false])
@endsection