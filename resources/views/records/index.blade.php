@extends('layouts.app')
@section('content')
@include('records.learning_record', ['hasRecords' => true, 'hasLikes' => false, 'hasRecordsTitle' => true])
@endsection