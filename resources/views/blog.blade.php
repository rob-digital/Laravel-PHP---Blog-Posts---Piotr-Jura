@extends('layout')

@section('content')
     {!! $say_hello !!}   {{ $data['title'] }}
     {{-- { !! $variable !! } it means that html or javascript code can be render to the DOM
     otherwise it would be escaped   - --}}
@endsection
