@extends('layouts.app')
@section('content')
@include('users.user')
@include('users.tabs', ['hasRecords' => false, 'hasLikes' => true])
@endsection